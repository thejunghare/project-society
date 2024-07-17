<?php

namespace App\Livewire\ManageUser;

use Exception;
use App\Models\Accountant;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;

class ManageAccountantIndex extends Component
{
    #[Rule('required|string')]
    #[Title('Manage Accountant')]

    // create accountant properties
    public $role_id = "2";
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
        $accountant = Accountant::findOrFail($id);
        $user = $accountant->user;

        // dd($this->s_id,$this->name);


        $this->s_id = $accountant->id;
        $this->name = $user->name;
        $this->role_id = $user->role_id;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->password = $user->password;
        $this->showModal = true;
    }

    public function updateaccountant()
    {
        $this->validate([
            'name' => 'required|string|min:4|max:50',
            'role_id' => 'required|numeric|min:1|max:3',
            'email' => 'required|email',
            'phone' => 'required|digits:10',
        ]);

        $accountant = Accountant::findOrFail($this->s_id);
        $user = $accountant->user;

        $user->update([
            'name' => $this->name,
            'role_id' => $this->role_id,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
        ]);


        $this->resetInputFields();
        // session()->flash('success', 'Accountant updated successfully.');

        $this->showModal = false;

        // Emit a browser event to refresh the page
        return redirect(route('accountantsIndex'))->with(['success' => 'Accountant updated successfully.']);
    }

    public function save()
    {
        $this->validate([
            'role_id' => 'required|numeric|min:1|max:3',
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|email',
            'phone' => 'required|digits:10',
            'password' => 'required|min:8',
        ]);

        // dd($this->role_id);

        $user = User::create([
            'name' => $this->name,
            'role_id' => $this->role_id,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
        ]);

        Accountant::create([
            'user_id' => $user->id,
        ]);

        // session()->flash('success', 'accountant added.');
        $this->resetInputFields();
        return redirect(route('accountantsIndex'))->with(['success' => 'Accountant added.']);
    }

    public function deleteaccountant($id)
    {
        try {
            $accountant = Accountant::findOrFail($id);

            $accountant->user->delete();
            $accountant->delete();

            session()->flash('success', 'Accountant deleted successfully.');
        } catch (Exception) {
            return redirect(route('accountantsIndex'))->with(['error' => 'Something went wrong. Try again later.']);
        }

        // Optionally, refresh the page
        return redirect(route('accountantsIndex'));
    }

    public function render()
    {
        $accountants = Accountant::whereHas('user', function ($query) {
            $query->where('role_id', 2)
                ->where('name', 'like', '%' . $this->search . '%');
        })
            ->latest()
            ->paginate(5);



        return view('livewire.manage-user.manage-accountant-index', [
            'accountants' => $accountants,
        ])->with('button', 'Create new accountant');
    }
}
