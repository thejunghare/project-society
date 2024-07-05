<?php

namespace App\Livewire\Societies;

use Livewire\Component;
use App\Models\MaintenanceBill;
use App\Models\Societies;
use App\Models\Member;
use Carbon\Carbon;
use Livewire\Attributes\Title;

class SocietyDetails extends Component
{
    #[Title(' Societies Details - mySocietyERP')]
    public $society;
    public $registeredMembers;
    public $receivableAmount;
    public $billDues;
    public $neverPaid;
    public $currentBill;
    public $advance;
    public $totalPayable;
    public $balance;

    public function mount(Societies $society)
    {
        $this->society = $society;
        $this->calculateReceivableAmount();
        $this->calculateBillDues();
        $this->calculateNeverPaid();
        $this->currentBill();
        $this->advanceBill();
        $this->calculateTotalPayable();
        $this->totalBalance();




        // $this->calculateBillDues();
        // $this->calculateNeverPaid();
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

    // public function societyTab(){
    //     return redirect()->
    // }

    public function calculateReceivableAmount()
    {
        // $this->registeredMembers = $this->society->members()->count();
        // $charges = $this->society->parking_charges + $this->society->service_charges;

        // $this->receivableAmount = $this->registeredMembers * $charges;
        $this->registeredMembers = $this->society->members()->count();
        $this->receivableAmount = 0;
    
        $members = $this->society->members;
    
        foreach ($members as $member) {
            // Add parking and service charges for each member
            $this->receivableAmount += $this->society->parking_charges + $this->society->service_charges;
    
            // Add appropriate maintenance amount based on is_rented status
            if ($member->is_rented == 1) {
                $this->receivableAmount += $this->society->maintenance_amount_rented;
            } else {
                $this->receivableAmount += $this->society->maintenance_amount_owner;
            }
        }
    }


    public function calculateBillDues()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $this->billDues = MaintenanceBill::whereHas('member', function ($query) {
            $query->where('society_id', $this->society->id);
        })->whereMonth('created_at', $currentMonth)
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

    public function advanceBill()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $this->advance = MaintenanceBill::whereHas('member', function ($query) {
            $query->where('society_id', $this->society->id);
        })->whereMonth('updated_at', $currentMonth)
            ->whereYear('updated_at', $currentYear)
            ->where('advance', '=', 1)->count();
    }

    public function currentBill()
    {
        // $currentMonth = Carbon::now()->month;
        // $currentYear = Carbon::now()->year;
        // $this->currentBill = MaintenanceBill::whereHas('member', function ($query) {
        //     $query->where('society_id', $this->society->id);
        // })->whereMonth('updated_at', $currentMonth)
        // ->whereYear('updated_at', $currentYear)
        // ->where('status', '=', 1)->count();
        $today = Carbon::today();

        $this->currentBill = MaintenanceBill::whereHas('member', function ($query) {
            $query->where('society_id', $this->society->id);
        })
            ->whereDate('updated_at', $today)
            ->where('status', '=', 1)
            ->count();
    }

    // public function calculateTotalPayable()
    // {
    //     // Calculate total charges based on society's parking and service charges
    //     $totalCharges = $this->society->parking_charges + $this->society->service_charges;

    //     // Calculate total payable by multiplying the number of advances by total charges
    //     $this->totalPayable = $totalCharges;
    // }

    public function calculateTotalPayable()
    {
        $totalPayable = 0;
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
    
        // Get all maintenance bills for advance payments this month
        $advancePayingBills = MaintenanceBill::whereHas('member', function ($query) {
            $query->where('society_id', $this->society->id);
        })
        ->where('advance', 1)
        ->whereMonth('updated_at', $currentMonth)
        ->whereYear('updated_at', $currentYear)
        ->get();
    
        foreach ($advancePayingBills as $bill) {
            $member = $bill->member;
            
            // Add parking and service charges for each bill
            $totalPayable += $this->society->parking_charges + $this->society->service_charges;
    
            // Add appropriate maintenance amount based on is_rent status
            if ($member->is_rented) {
                $totalPayable += $this->society->maintenance_amount_rented;
            } else {
                $totalPayable += $this->society->maintenance_amount_owner;
            }
        }
    
        $this->totalPayable = $totalPayable;
    }


    public function totalBalance()
    {
        $this->balance = $this->society->registered_balance + $this->society->updated_balance;
    }

    // public function addMember($memberId)
    // {
    //     $member = Members::find($memberId);
    //     if ($member) {
    //         $this->society->members()->attach($member);
    //         $this->removeMaintenanceBill($memberId);
    //         $this->calculateReceivableAmount();
    //         $this->calculateBillDues();
    //         $this->calculateNeverPaid();
    //     }
    // }

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
            'registeredMembers' => $this->registeredMembers
        ]);
    }
}
