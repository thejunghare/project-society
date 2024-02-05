<?php

namespace App\Livewire\Societies;

use App\Models\Societies;
use Livewire\Component;

class ManageSocietiesIndex extends Component
{
    public $societyOptions;
    public function render()
    {
        // return view('livewire.societies.manage-societies-index');
        return view('livewire.societies.manage-societies-index', [
            'societies' => Societies::latest()->where('accountant_id', 1)->paginate(5),
            // 'societyOptions' => Societies::pluck()->where('accountant_id', 1)->paginate(5),
        ])
            ->title('Manage societies - Society')
            ->with([
                'button' => 'Create new user'
            ]);

    }
}
