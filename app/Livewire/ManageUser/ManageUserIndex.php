<?php

namespace App\Livewire\ManageUser;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Rule;

class ManageUserIndex extends Component
{

    public $users;

    #[Rule('required|string')]
    public $name;

    public function mount()
    {
        $this->users = User::all();
    }

    public function save()
    {
        // dd($this->name);

        $this->validate();

        User::create([
            'role_id' => 3,
            'name' => $this->name
        ]);

        session()->flash('success','User added!');

        return $this->redirect(route('manage'));
    }

    public function render()
    {
        return view('livewire.manage-user.manage-user-index')
            ->title('Manage Users - Society')
            ->with([
                'button' => 'New user'
            ]);
    }
}
