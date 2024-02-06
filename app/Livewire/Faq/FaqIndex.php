<?php

namespace App\Livewire\Faq;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("FAQs - Society")]
class FaqIndex extends Component
{
    public function render()
    {
        return view('livewire.faq.faq-index');
    }
}
