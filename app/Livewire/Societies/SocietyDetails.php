<?php

namespace App\Livewire\Societies;

use Livewire\Component;
use App\Models\Societies;


class SocietyDetails extends Component
{
   
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

    public $society;

    public function mount(Societies $society)
    {
        $this->society = $society;
    }
    public function render()
    {
        return view('livewire.societies.society-details');
    }
}
