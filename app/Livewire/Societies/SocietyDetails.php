<?php
namespace App\Livewire\Societies;

use Livewire\Component;
use App\Models\MaintenanceBill;
use App\Models\Societies;
use Carbon\Carbon;
use Livewire\Attributes\Title;

class SocietyDetails extends Component
{
    #[Title('Societies Details - mySocietyERP')]
    public $society;
    public $registeredMembers;
    public $receivableAmount;
    public $billDues;
    public $neverPaid;
    public $currentBill;
    public $advance;
    public $totalPayable;
    public $balance;
    public $payOnline;

    public function mount(Societies $society)
    {
        $this->society = $society;
        $this->calculateReceivableAmount();
        $this->calculateBillDues();
        $this->calculateNeverPaid();
        $this->calculateCurrentBill();
        $this->calculateAdvanceBill();
        $this->calculateTotalPayable();
        $this->calculateBalance();
        $this->calculatePayOnline();
    }

    public function seeMembers()
    {
        return redirect()->route('members', ['society' => $this->society->id]);
    }

    public function goBack()
    {
        return redirect('/accountant/manage/societies/');
    }

    public function seeMaintenanceBills()
    {
        return redirect()->route('maintenance-bill', ['society' => $this->society->id]);
    }

    public function calculateReceivableAmount()
    {
        $this->registeredMembers = $this->society->members()->count();
        $this->receivableAmount = 0;

        foreach ($this->society->members as $member) {
            $this->receivableAmount += $this->society->parking_charges + $this->society->service_charges;
            $this->receivableAmount += $member->is_rented ? $this->society->maintenance_amount_rented : $this->society->maintenance_amount_owner;
        }

        // Ensure it's a float for number_format
        $this->receivableAmount = (float) $this->receivableAmount;
    }

    public function calculatePayOnline()
    {
        $today = Carbon::today();
    
        $this->payOnline = MaintenanceBill::whereHas('member', function ($query) {
            $query->where('society_id', $this->society->id);
        })
        ->whereDate('updated_at', $today)
        ->where('status', 1)
        ->where('payment_mode_id', 1)
        ->sum('amount');  // Summing the 'amount' field
    }
    

    public function calculateBillDues()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $this->billDues = MaintenanceBill::whereHas('member', function ($query) {
            $query->where('society_id', $this->society->id);
        })
        ->whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->count();
    }

    public function calculateNeverPaid()
    {
        $this->neverPaid = MaintenanceBill::whereHas('member', function ($query) {
            $query->where('society_id', $this->society->id);
        })
        ->select('member_id')
        ->groupBy('member_id')
        ->havingRaw('MAX(status) != 1')
        ->count();
    }

    public function calculateAdvanceBill()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $this->advance = MaintenanceBill::whereHas('member', function ($query) {
            $query->where('society_id', $this->society->id);
        })
        ->whereMonth('updated_at', $currentMonth)
        ->whereYear('updated_at', $currentYear)
        ->where('advance', 1)
        ->count();
    }

    public function calculateCurrentBill()
    {
        $today = Carbon::today();
        $this->currentBill = MaintenanceBill::whereHas('member', function ($query) {
            $query->where('society_id', $this->society->id);
        })
        ->whereDate('updated_at', $today)
        ->where('status', 1)
        ->count();
    }

    public function calculateTotalPayable()
    {
        $totalPayable = 0;
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $advancePayingBills = MaintenanceBill::whereHas('member', function ($query) {
            $query->where('society_id', $this->society->id);
        })
        ->where('advance', 1)
        ->whereMonth('updated_at', $currentMonth)
        ->whereYear('updated_at', $currentYear)
        ->get();

        foreach ($advancePayingBills as $bill) {
            $member = $bill->member;
            $totalPayable += $this->society->parking_charges + $this->society->service_charges;
            $totalPayable += $member->is_rented ? $this->society->maintenance_amount_rented : $this->society->maintenance_amount_owner;
        }

        // Ensure it's a float for number_format
        $this->totalPayable = (float) $totalPayable;
    }

    public function calculateBalance()
    {
        $this->balance = (float) ($this->society->registered_balance + $this->society->updated_balance);
    }

    public function render()
    {
        return view('livewire.societies.society-details', [
            'registeredMembers' => $this->registeredMembers,
            'receivableAmount' => $this->receivableAmount,
            'billDues' => $this->billDues,
            'neverPaid' => $this->neverPaid,
            'currentBill' => $this->currentBill,
            'advance' => $this->advance,
            'totalPayable' => $this->totalPayable,
            'balance' => $this->balance,
            'payOnline' => $this->payOnline,
        ])->layout('layouts.app', ['society' => $this->society]);
    }
}
