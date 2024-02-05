<?php

namespace App\Livewire\Societies;

use Livewire\Component;
use App\Models\Societies;

class SocietyFormOptionWithOutModal extends Component
{
    public $societyId;
    public $societyName;

    public $selectedSociety;


    public function mount()
    {
        $this->societyName = Societies::pluck('name', 'id');
    }
    public function render()
    {
        return view('livewire.societies.society-form-option-with-out-modal');
    }
}
