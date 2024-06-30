<?php

namespace App\Livewire\Societies;

use Livewire\Component;
use App\Models\Societies;

class SocietyDetails extends Component
{
    public $society;
    public $registeredMembers;
    public $receivableAmount;

    public function mount(Societies $society)
    {
        $this->society = $society;
        $this->calculateReceivableAmount();
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

    public function render()
    {
        return view('livewire.societies.society-details', [
            'registeredMembers' => $this->registeredMembers,
            'receivableAmount' => $this->receivableAmount,
        ]);
    }
}
