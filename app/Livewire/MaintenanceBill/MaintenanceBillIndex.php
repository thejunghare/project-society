<?php

namespace App\Livewire\MaintenanceBill;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Member;
use App\Models\Societies;

class MaintenanceBillIndex extends Component
{
    #[Title('Maintenance Bill - mySocietyERP')]
    public $societies, $months, $search, $selected_society, $selected_year, $selected_month, $members;

    public function mount()
    {
        $this->societies = Societies::where('accountant_id', Auth::user()->id)->pluck('name', 'id');
        $this->months = $this->returnMonths();
    }

    public function returnMonths()
    {
        return [
            'January', 'February', 'March', 'April',
            'May', 'June', 'July', 'August',
            'September', 'October', 'November', 'December'
        ];
    }

    public function render()
    {
        $members = $this->selected_society
            ? Member::join('maintenance_bills', 'members.id', '=', 'maintenance_bills.member_id')
                ->join('users', 'members.user_id', '=', 'users.id')
                ->where('members.society_id', $this->selected_society)
                ->where(function ($query) {
                    $query->where('users.name', 'like', "%{$this->search}%")
                        ->orWhere('users.phone', 'like', "%{$this->search}%")
                        ->orWhere('users.email', 'like', "%{$this->search}%");
                })
                ->select(
                    'members.id as member_id',
                    'members.society_id',
                    'members.user_id',
                    'users.name',
                    'users.phone',
                    'users.email',
                    'maintenance_bills.id as bill_id',
                    'maintenance_bills.billing_month',
                    'maintenance_bills.amount',
                    'maintenance_bills.status',
                    'members.created_at'
                )
                ->latest('members.created_at')
                ->paginate(5)
            : collect();
        return view(
            'livewire.maintenance-bill.maintenance-bill-index', [
            'months' => $this->months,
            'members' => $members,
        ]);
    }
}

