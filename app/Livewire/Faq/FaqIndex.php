<?php

namespace App\Livewire\Faq;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Faq;
use Livewire\WithPagination;

#[Title("FAQs - Society")]

class FaqIndex extends Component
{

    public function render()
    {
        return view('livewire.faq.faq-index', [
            'records' => Faq::paginate(2),
        ]);
    }
}
