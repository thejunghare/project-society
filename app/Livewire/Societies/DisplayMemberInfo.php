<?php

namespace App\Livewire\Societies;

use Livewire\Component;
use App\Models\MaintenanceBill;
use Carbon\Carbon;
use App\Models\Member;
use App\Models\Societies;
use Illuminate\Support\Facades\Auth;

class DisplayMemberInfo extends Component
{
    public $member;
    public $totalPayable;
    public $maintenance;
    public $registeredMembers;
    public $receivableAmount;
    public $society;

    public function mount()
    {
        $this->member = Auth::user()->member;
        $this->society = Societies::find($this->member->society_id);
        $this->maintenance = $this->maintenancePayable();
        $this->calculateTotalPayable();
        $this->calculateReceivableAmount();
        $this->resetSelection();
    }

    public function maintenancePayable()
    {
        if ($this->society) {
            if ($this->member->is_rented) {
                return $this->society->maintenance_amount_rented;
            } else {
                return $this->society->maintenance_amount_owner;
            }
        } else {
            return 0;
        }
    }

    // public function calculateTotalPayable()
    // {
    //     if ($this->society) {
    //         $currentMonth = Carbon::now()->startOfMonth();
    //         $nextMonth = $currentMonth->copy()->addMonth();

    //         // Calculate total payable based on maintenance bills for the current month and society
    //         $totalPayable = MaintenanceBill::whereHas('member', function ($query) {
    //             $query->where('society_id', $this->society->id);
    //         })
    //             ->where('status', 1) // Only include paid bills
    //             ->whereBetween('updated_at', [$currentMonth, $nextMonth]) // Only include bills updated this month
    //             ->sum('amount');

    //         // Add maintenance amount for this member
    //         // $totalPayable += $this->maintenance;

    //         $this->totalPayable = $totalPayable;
    //     } else {
    //         $this->totalPayable = 0; // Default to 0 if society not found
    //     }
    // }

    public $selectedYear;
    public $selectedMonth;

    public function calculateTotalPayable($year = null, $month = null)
    {
        if ($this->society) {
            // Use provided year and month, or default to current if not provided
            $year = $year ?? $this->selectedYear ?? Carbon::now()->year;
            $month = $month ?? $this->selectedMonth ?? Carbon::now()->month;

            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();

            // Calculate total payable based on maintenance bills for the selected month/year and society
            $totalPayable = MaintenanceBill::whereHas('member', function ($query) {
                $query->where('society_id', $this->society->id);
            })
                ->where('status', 1) // Only include paid bills
                ->whereBetween('updated_at', [$startDate, $endDate]) // Filter by selected month and year
                ->sum('amount');

            // Add maintenance amount for this member

            $this->totalPayable = $totalPayable;
        } else {
            $this->totalPayable = 0; // Default to 0 if society not found
        }
    }

    public function updateSelectedYear($year)
    {
        $this->selectedYear = $year;
        $this->calculateTotalPayable();
    }

    public function updateSelectedMonth($month)
    {
        $this->selectedMonth = $month;
        $this->calculateTotalPayable(); 
    }

    public function resetSelection()
    {
        $this->selectedYear = now()->year;
        $this->selectedMonth = now()->month;
        $this->calculateTotalPayable();
    }


    public function calculateReceivableAmount()
    {
        if ($this->society) {
            $this->registeredMembers = $this->society->members()->count();
            $this->receivableAmount = 0;

            foreach ($this->society->members as $member) {
                $this->receivableAmount += $this->society->parking_charges + $this->society->service_charges;
                $this->receivableAmount += $member->is_rented ? $this->society->maintenance_amount_rented : $this->society->maintenance_amount_owner;
            }

            // Ensure it's a float for number_format
            $this->receivableAmount = (float) $this->receivableAmount;
        } else {
            $this->receivableAmount = 0;
        }
    }

    public function render()
    {
        return view('livewire.societies.display-member-info', [
            'totalPayable' => $this->totalPayable,
            'maintenance' => $this->maintenance,
            'receivableAmount' => $this->receivableAmount
        ]);
    }
}
