<?php

namespace App\Livewire\ManageUser;

use Exception;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;

class ManageUserIndex extends Component
{

    // public $users;

    #[Rule('required|string')]
    #[Title('Manage Users - Society')]

    // create user

    public $role_id;
    public $name;
    public $email;
    public $phone;
    public $password;
    public $search;
    public $showModal = false;

    // update the users table's data
    public $editUserId;
    public $editUserName;
    public $editUserRole;
    public $editUserEmail;
    public $editUserPhone;

    use WithPagination;

    public function mount()
    {

    }

    public function save()
    {
        $this->validate([
            'role_id' => ['required', 'numeric', 'min:1', 'max:3'],
            'name' => ['required', 'string', 'min:4', 'max:50'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['required'],
            'password' => ['required', 'min:8'],
        ]);

        User::create([
            'role_id' => $this->role_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
        ]);

        session()->flash('success', 'User added.');
        return $this->redirect(route('users'));

    }

    /*   public function openModal()
      {
          $this->showModal = true;
      } */

    public function edit($userId)
    {
        $this->editUserId = $userId;
        $this->editUserName = User::find($userId)->name;
        $this->editUserRole = User::find($userId)->role_id;
        $this->editUserEmail = User::find($userId)->email;
        $this->editUserPhone = User::find($userId)->phone;
    }

    public function cancelEdit()
    {
        $this->reset('editUserId', 'editUserName', 'editUserRole', 'editUserEmail', 'editUserPhone');
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
            ->with([
                'button' => 'Create new user'
            ]);
    }
}
