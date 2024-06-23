<?php

namespace App\Livewire\Societies;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class DisplayMemberInfo extends Component
{
    public $member;

    public function mount()
    {
        $this->member = Auth::user()->member;
    }

    public function render()
    {
        return view('livewire.societies.display-member-info');
    }
}
