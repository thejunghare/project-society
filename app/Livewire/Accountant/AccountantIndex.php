<?php

namespace App\Livewire\Accountant;

use App\Models\Member;
use App\Models\Societies;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AccountantIndex extends Component
{
    public $registeredSocietiesCount;

    public $getRegisteredSocietiesId;

    public $registeredSocietyMembersCount;

    public function mount()
    {
        $this->registeredSocietiesCount = Societies::where('accountant_id', Auth::user()->id)->count();
        $this->getRegisteredSocietiesId = Societies::where('accountant_id', Auth::user()->id)->pluck('id')->toArray();
        $this->registeredSocietyMembersCount = Member::whereIn('society_id', $this->getRegisteredSocietiesId)->count();
    }

    public function render()
    {
        return view('livewire.accountant.accountant-index')
            ->title('Accountant dashboard - Society');
    }
}
