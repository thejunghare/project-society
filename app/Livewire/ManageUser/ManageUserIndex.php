<?php

namespace App\Livewire\ManageUser;

use Exception;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\Hash;

class ManageUserIndex extends Component
{

    // public $users;

    #[Rule('required|string')]
    public $name;
    public $email;
    public $phone;
    public $password;
    public $search;
    use WithPagination;

    public function mount()
    {
    }

    public function save()
    {
        $this->validate([
            'name' => ['required', 'string', 'min:4', 'max:50'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['required'],
            'password' => ['required', 'min:8'],
        ]);

        User::create([
            'role_id' => 3,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
        ]);

        session()->flash('success', 'User added.');
        return $this->redirect('/manage');
    }

    public function delete($userId)
    {
        try {
            User::findOrFail($userId)->delete();
            session()->flash('success', 'User has been deleted.');
            // $this->reset();
        } catch (Exception $e) {
            session()->flash('error', 'Something went wrong.');
            return;
        }
    }

    public function render()
    {
        return view('livewire.manage-user.manage-user-index', [
            'users' => User::latest()->where('name', 'like', "%{$this->search}%")->paginate(5),
        ])
            ->title('Manage Users - Society')
            ->with([
                'button' => 'New user'
            ]);
    }
}
