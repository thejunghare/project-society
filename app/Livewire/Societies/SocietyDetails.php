<?php

namespace App\Livewire\Societies;

use Livewire\Component;
use App\Models\MaintenanceBill;
use App\Models\Societies;
use App\Models\Member;
use Carbon\Carbon;

class SocietyDetails extends Component
{
    public $society;
    public $registeredMembers;
    public $receivableAmount;
    public $billDues;
    public $neverPaid;
    public $currentBill;
    public $advance;

    public function mount(Societies $society)
    {
        $this->society = $society;
        $this->calculateReceivableAmount();
        $this->calculateBillDues();
        $this->calculateNeverPaid();
        $this->currentBill();
        $this->advanceBill();



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

    public function calculateReceivableAmount()
    {
        $this->registeredMembers = $this->society->members()->count();
        $this->receivableAmount = $this->registeredMembers * 500;
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

    public function advanceBill(){
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $this->advance = MaintenanceBill::whereHas('member', function ($query) {
            $query->where('society_id', $this->society->id);
        })->whereMonth('updated_at', $currentMonth)
        ->whereYear('updated_at', $currentYear)
        ->where('advance', '=', 1)->count();
    }

    public function currentBill(){
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $this->currentBill = MaintenanceBill::whereHas('member', function ($query) {
            $query->where('society_id', $this->society->id);
        })->whereMonth('updated_at', $currentMonth)
        ->whereYear('updated_at', $currentYear)
        ->where('status', '=', 1)->count();

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
            'advance' => $this->advance
        ]);
    }
}
