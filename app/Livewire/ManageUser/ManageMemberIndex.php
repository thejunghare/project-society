<?php

namespace App\Livewire\ManageUser;

use Exception;
use App\Models\Member;
use App\Models\Societies;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;

class ManageMemberIndex extends Component
{
    #[Rule('required|string')]
    #[Title('Manage Members')]

    // create member properties
    public $role_id = "3";
    public $society_id = "";
    public $society_name = "";

    public $is_rented = "";
    public $name = "";
    public $email = "";
    public $room_number = "";
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
        $this->reset(['name', 'role_id', 'society_id', 'room_number', 'is_rented', 'email', 'phone']);
    }

    public function edit($id)
    {

        $member = Member::find($id);
        $user = $member->user;
        $society = Societies::find($member->society_id);

        // dd($society->name);

        if ($member->is_rented == 1) {
            $this->is_rented = "Yes";
        } else {
            $this->is_rented = "No";
        }

        $this->society_id = $member->society_id;
        $this->room_number = $member->room_number;
        $this->s_id = $member->id;
        $this->name = $user->name;
        $this->society_name = $society->name;
        $this->role_id = $user->role_id;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->password = $user->password;
        $this->showModal = true;
    }

    public function updateMember()
    {
        $this->validate([
            'name' => 'required|string',
            'email' => 'required',
            'phone' => 'required|digits:10',
            'password' => 'required|min:8',
            'society_id' => 'required',
            'is_rented' => 'nullable|in:Yes,No',
            'room_number' => 'nullable',
        ]);

        $member = Member::find($this->s_id);
        $user = $member->user;


        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        // Update specific fields if condition is met
        if ($this->is_rented == 'Yes') {
            $memberData['is_rented'] = '1';
            // dd($memberData['is_rented'],$memberData['room_number']);
        } else {
            $memberData['is_rented'] = '0'; // Ensure is_rented is reset if it's not 'Yes'
            // $memberData['room_number'] = '0'; // Reset room_number if not rented
        }
        
        $memberData['room_number'] = $this->room_number;
        $memberData['society_id'] = $this->society_id;


        $member->update($memberData);

        $this->updateMemberCountForSociety($this->society_id);

        $this->resetInputFields();
        
        $this->showModal = false;

        // Emit a browser event to refresh the page
        return redirect(route('membersIndex'))->with(['success' => 'Member updated successfully.']);
    }


    public function save()
    {
        // Validate input fields
        $validatedData = $this->validate([
            'role_id' => 'required|numeric|min:1|max:3',
            'name' => 'required|string|min:4|max:50',
            'email' => 'required|email|unique:users,email', // Ensure email is unique in the users table
            'phone' => 'required|digits:10',
            'password' => 'required|min:8',
            'society_id' => 'required', // Ensure society_id exists in societies table
            'is_rented' => 'nullable|in:Yes,No', // Optional, only Yes or No
            'room_number' => 'nullable|string', // Optional room number
        ]);


        // Create the user
        $user = User::create([
            'name' => $this->name,
            'role_id' => $this->role_id,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
        ]);

        // Determine if the member is rented
        $isRented = $this->is_rented === 'Yes' ? '1' : '0';


        // dd($this->society_id,);
        
        // Create the member
        Member::create([
            'user_id' => $user->id,
            'society_id' => $this->society_id,
            'is_rented' => $isRented,
            'room_number' => $this->room_number ?? '',
        ]);

        // Updates the member_count
        $this->updateMemberCountForSociety($this->society_id);

        // Reset input fields
        $this->resetInputFields();

        // Redirect with success message
        return redirect(route('membersIndex'))->with(['success' => 'Member added.']);
    }

    // Function to update the member_count
    public function updateMemberCountForSociety($society_id)
    {
        $memberCount = Member::where('society_id', $society_id)->count();
        Societies::where('id', $society_id)->update(['member_count' => $memberCount]);
    }

    public function deleteMember($id)
    {
        $member = Member::findOrFail($id);

        $member->user->delete();
        $member->delete();

        session()->flash('success', 'Member deleted successfully.');

        

        // Optionally, refresh the page
        return redirect(route('membersIndex'));
    }

    public function render()
    {
        $members = Member::whereHas('user', function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })
            ->latest()
            ->paginate(5);
        //  dd($members);

        $societies = Societies::all(); // Fetch all societies

        return view('livewire.manage-user.manage-member-index', [
            'members' => $members,
            'societies' => $societies,
        ])->with('button', 'Create new member');
    }
}
