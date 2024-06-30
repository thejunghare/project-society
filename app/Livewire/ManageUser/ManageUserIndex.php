<?php

namespace App\Livewire\ManageUser;

use Exception;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;

class ManageUserIndex extends Component
{
    #[Rule('required|string')]
    #[Title('Manage Members - Society')]

    // create user properties
    public $role_id = "";
    public $name = "";
    public $email = "";
    public $phone = "";
    public $password = "";
    public $search = "";
    public $showModal = false;
    public $s_id;

    use WithPagination;

    public function mount()
    {
        $this->resetInputFields();
    }

    public function resetInputFields()
    {
        $this->reset(['name', 'role_id', 'email', 'phone']);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        $this->s_id = $user->id;
        $this->name = $user->name;
        $this->role_id = $user->role_id;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->showModal = true;
    }

    public function updateUser()
    {
        $this->validate([
            'name' => 'required|string|min:4|max:50',
            'role_id' => 'required|numeric|min:1|max:3',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $user = User::findOrFail($this->s_id);
        $user->update([
            'name' => $this->name,
            'role_id' => $this->role_id,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        $this->resetInputFields();
        session()->flash('message', 'User updated successfully.');

        $this->showModal = false;

        // Emit a browser event to refresh the page
        return redirect()->to(route('users'));;
    }

    public function save()
    {
        // $this->validate([
        //     'role_id' => 'required|numeric|min:1|max:3',
        //     'name' => 'required|string|min:4|max:50',
        //     'email' => 'required|email|unique:users',
        //     'phone' => 'required',
        //     'password' => 'required|min:8',
        // ]);

        $this->validate([
            'name' => 'required|string|min:2|max:50',
            'role_id' => 'required|numeric|min:1|max:3',
            'email' => 'required|email',
            'phone' => 'required',
        ]);
        // dd('Users data called', $this->name, $this->role_id, $this->email, $this->phone, $this->password);

        User::create([
            'name' => $this->name,
            'role_id' => $this->role_id,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make('password'),
        ]);

        session()->flash('message', 'User added.');
        $this->resetInputFields();  
        return redirect(route('users'));    
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

    // if ($user->members) {
    //     // Delete related maintenance bills through members
    //     foreach ($user->members as $member) {
    //         $member->maintenanceBills()->delete();
    //     }

    //     // Delete related members
    //     $user->members()->delete();
    // }

        $user->delete();

        session()->flash('success', 'User deleted successfully.');

        // Optionally, refresh the page
        return redirect(route('users'));
    }

    public function render()
    {
        $users = User::where('role_id', 3)
            ->where('name', 'like', "%{$this->search}%")
            ->latest()
            ->paginate(5);

        return view('livewire.manage-user.manage-user-index', [
            'users' => $users,
        ])->with('button', 'Create new user');
    }
}
