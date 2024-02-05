<?php

namespace App\Livewire\Members;

use App\Models\Member;
use Livewire\Component;

class ManageSocietiesMembersIndex extends Component
{
    public function render()
    {
        return view('livewire.members.manage-societies-members-index', [
            'members' => Member::latest()->paginate(5),
        ])
            ->title('Manage societies members - Society')
            ->with([
                'button' => 'Create new user'
            ]);
    }
}
