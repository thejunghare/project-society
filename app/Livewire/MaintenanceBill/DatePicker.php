<?php

namespace App\Livewire;

use Livewire\Component;

class DatePicker extends Component
{
    public $name;
    public $label;
    public $value;
    public $min;
    public $max;

    public function mount($name, $label = '', $value = null, $min = null, $max = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->min = $min;
        $this->max = $max;
    }

    public function render()
    {
        return view('livewire.date-picker');
    }
}