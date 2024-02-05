<?php

namespace App\Livewire\Societies;

use App\Models\Member;
use Livewire\Component;
use App\Models\Societies;
use Illuminate\Support\Facades\Auth;

class SocietyFormOption extends Component
{
    public $societyId;
    public $societyName;

    public $selectedSociety;

    public function save()
    {
        // dd($this->selectedSociety);

        Member::create([
            'user_id' => Auth::user()->id,
            'society_id' => $this->selectedSociety,
        ]);

        session()->flash('success', 'Your are now a member.');
        return $this->redirect('/dashboard');
    }

    public function mount()
    {
        $this->societyName = Societies::pluck('name', 'id');
    }


    public function render()
    {
        return view('livewire.societies.society-form-option');
    }
}
