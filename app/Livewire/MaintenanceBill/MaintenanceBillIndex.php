<?php

namespace App\Livewire\MaintenanceBill;

use App\Models\Member;
use App\Models\Societies;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\MaintenanceBill;


class MaintenanceBillIndex extends Component
{
    use WithPagination;

    #[Title('Maintenance Bill - mySocietyERP')]
    public $societies, $months, $search, $selected_society, $selected_year, $selected_month, $members;
    public $selectedMembers = [];
    public $selectAll = false;

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedMembers = $this->members->pluck('id')->toArray();
        } else {
            $this->selectedMembers = [];
        }
    }

    public function mount()
    {
        $this->societies = Societies::where('accountant_id', Auth::user()->id)->pluck('name', 'id');
        $this->months = $this->returnMonths();
        $this->members = collect(); // Initialize members as an empty collection
    }

    public function returnMonths()
    {
        return [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];
    }

    public function updatedSelectedSociety()
    {
        $this->fetchMembers();
    }

    public function updatedSelectedYear()
    {
        $this->fetchMembers();
    }

    public function updatedSelectedMonth()
    {
        $this->fetchMembers();
    }

    public function fetchMembers()
    {
        if ($this->selected_society && $this->selected_year && $this->selected_month) {
            $this->members = Member::join('maintenance_bills', 'members.id', '=', 'maintenance_bills.member_id')
                ->join('users', 'members.user_id', '=', 'users.id')
                ->where('members.society_id', $this->selected_society)
                ->where('maintenance_bills.billing_year', $this->selected_year)
                ->where('maintenance_bills.billing_month', $this->selected_month)
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
                ->get();
        } else {
            $this->members = collect();
        }
    }

    public function download($memberId)
    {
        $member = Member::with('user')->findOrFail($memberId);

        $bill = MaintenanceBill::where('member_id', $memberId)->firstOrFail();

        $society = Societies::where('id', $member->society_id)->firstOrFail();

        $data = [
            'member' => $member,
            'bill' => $bill,
            'society' => $society,
        ];

        $pdf = Pdf::loadView('pdfs.invoice', $data);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'invoice.pdf');
    }

    public function downloadSelected()
    {
        if (empty($this->selectedMembers)) {
            return;
        }

        $members = Member::with('user')->whereIn('id', $this->selectedMembers)->get();

        if ($members->isEmpty()) {
            return;
        }

        $society = Societies::find($members->first()->society_id);

        if (!$society) {
            return;
        }

        $bills = MaintenanceBill::whereIn('member_id', $this->selectedMembers)->get();

        $data = [
            'members' => $members,
            'bills' => $bills,
            'society' => $society,
        ];

        $pdf = Pdf::loadView('pdfs.invoices', $data);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'invoices.pdf');
    }


    public function render()
    {
        return view('livewire.maintenance-bill.maintenance-bill-index', [
            'months' => $this->months,
            'members' => $this->members,
        ]);
    }
}
