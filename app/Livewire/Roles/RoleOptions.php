<?php

namespace App\Livewire\Roles;

use App\Models\Role;
use Livewire\Component;

class RoleOptions extends Component
{
    public $roles;

    public function mount()
    {
        $this->roles = Role::all();
    }
    public function render()
    {
        return view('livewire.roles.role-options');
    }
}
