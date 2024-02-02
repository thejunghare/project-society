<?php

namespace App\Livewire\ManageUser;

use App\Models\User;
use Livewire\Component;

class ManageUserIndex extends Component
{

    public $users;

    public function mount()
    {
        $this->users = User::all();
    }

    public function render()
    {
        return view('livewire.manage-user.manage-user-index')
            ->title('Manage Users - Society');
    }
}
