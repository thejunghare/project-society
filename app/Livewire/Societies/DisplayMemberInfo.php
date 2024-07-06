<?php

namespace App\Livewire\Societies;

use Livewire\Component;
use App\Models\Member;
use App\Models\Societies; // Correct import
use Illuminate\Support\Facades\Auth;

class DisplayMemberInfo extends Component
{
    public $member;
    public $totalPayable;
    public $maintenance;

    public function mount()
    {
        $this->member = Auth::user()->member;
        $this->maintenance = $this->maintenancePayable();
        $this->calculateTotalPayable();
    }

    public function maintenancePayable()
    {
        $society = Societies::find($this->member->society_id);
        if ($society) {
            if ($this->member->is_rented) {
                return $society->maintenance_amount_rented;
            } else {
                return $society->maintenance_amount_owner;
            }
        } else {
            return 0;
        }
    }

    public function calculateTotalPayable()
    {
        // Fetch the society details
        $society = Societies::find($this->member->society_id);

        if ($society) {
            // Add parking and service charges for each bill
            $totalPayable = $society->parking_charges + $society->service_charges;

            // Add the maintenance amount
            $totalPayable += $this->maintenance;

            $this->totalPayable = $totalPayable;
        } else {
            $this->totalPayable = 0; // Default to 0 if society not found
        }
    }

    public function render()
    {
        return view('livewire.societies.display-member-info', [
            'totalPayable' => $this->totalPayable,
            'maintenance' => $this->maintenance,
        ]);
    }
}
