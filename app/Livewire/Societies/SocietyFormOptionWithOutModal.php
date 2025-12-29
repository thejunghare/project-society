<?php

namespace App\Livewire\Societies;

use Livewire\Component;
use App\Models\Societies;
use Illuminate\Support\Facades\Auth;

class SocietyFormOptionWithOutModal extends Component
{
    public $societyId;
    public $societyName;
    public $societies;

    public $selectedSociety;


    public function mount()
    {
        // $this->societyName = Societies::pluck('name', 'id')->where('accountant_id', Auth::user()->id);
        $this->societies = Societies::pluck('name', 'id')->where('accountant_id', Auth::user()->id);
        // $this->societyName = Societies::where('accountant_id', 1)->pluck('name', 'id');

    }
    public function render()
    {
        return view('livewire.societies.society-form-option-with-out-modal');
    }
}
