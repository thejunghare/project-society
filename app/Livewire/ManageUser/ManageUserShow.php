<?php

namespace App\Livewire\ManageUser;

use App\Models\User;
use Livewire\Component;

class ManageUserShow extends Component
{

    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }
    public function render()
    {
        return view('livewire.manage-user.manage-user-show');
    }
}
