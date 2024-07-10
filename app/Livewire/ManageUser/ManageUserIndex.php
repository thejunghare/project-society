<?php

namespace App\Livewire\ManageUser;

use Exception;
use App\Models\User;
use App\Models\Role;
use App\Models\Member;
use App\Models\Societies;
use App\Models\Accountant;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;

class ManageUserIndex extends Component
{
    #[Rule('required|string')]
    #[Title('Manage Users')]


    public $selectedUsers = [];
    // create user properties
    public $role_id = "3";
    public $roleName = "";
    
    public $name = "";
    public $email = "";
    public $phone = "";
    public $password = "";
    public $search = "";
    public $showModal = false;
    public $s_id="";
    public $userId="";
    public $promoteTo ="";
    public $promotionId ="";

    public $societies = "";
    
    public $society_id = "";
    public $is_rented = "";
    public $room_number = "";




    use WithPagination;



    public function mount()
    {
        $this->societies = Societies::all();
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
        $this->password = $user->password;
        $this->showModal = true;

        $role = Role::find($this->role_id);
        $this->roleName = $role->role;
        // dd($this->roleName);
    }

    public function updateUser()
    {
        $this->validate([
            'name' => 'required|string|min:3|max:50',
            'role_id' => 'required',
            'email' => 'required|email',
            'phone' => 'required|digits:10',
            'password' => 'required|min:8'
        ]);

        $user = User::findOrFail($this->s_id);
        $user->update([
            'name' => $this->name,
            'role_id' => $this->role_id,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password
        ]);

        $this->resetInputFields();
        session()->flash('success', 'User updated successfully.');

        $this->showModal = false;

        // Emit a browser event to refresh the page
        return redirect()->to(route('usersIndex'));;
    }

    public function save()
    {
        
        $this->validate([
            'name' => 'required|string|min:2|max:50',
            'role_id' => 'required',
            'email' => 'required',
            'phone' => 'required|digits:10',
            'password' => 'required|min:8'
        ]);
        // dd('Users data called', $this->name, $this->role_id, $this->email, $this->phone, $this->password);

        User::create([
            'name' => $this->name,
            'role_id' => $this->role_id,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make('password'),
        ]);

        session()->flash('success', 'User added.');
        $this->resetInputFields();  
        return redirect(route('usersIndex'));    
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
        return redirect(route('usersIndex'));
    }
    
    public function buttonClicked($role)
    {
        $this->promoteTo = $role;

        if($this->promoteTo=='Member'){
            $this->promotionId = 4;
            if (count($this->selectedUsers) ==1 ){
                $this->viewUser( $this->selectedUsers[0]);
            }elseif (count($this->selectedUsers) ==0 ){
                session()->flash('error', 'Select user to promote.');
                return redirect(route('usersIndex'));
            }else{
                session()->flash('error', 'Select only one user.');
                return redirect(route('usersIndex'));
            }
        }elseif ($this->promoteTo=='Accountant'){
            $this->promotionId = 2;
            if (count($this->selectedUsers) ==1 ){
                $this->viewUser( $this->selectedUsers[0]);
            }elseif (count($this->selectedUsers) ==0 ){
                session()->flash('error', 'Select user to promote.');
                return redirect(route('usersIndex'));
            }else{
                session()->flash('error', 'Select only one user.');
                return redirect(route('usersIndex'));
            }
        }
        // dd($this->promoteTo);
    }

    public function viewUser($userId){
        $user = User::find($userId);
        

        $this->userId = $userId;
        $this->name = $user->name;
        $this->role_id = $user->role_id;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->password = $user->password;

        $role = Role::find($this->role_id);
        $this->roleName = $role->role;

        
        if($user->role_id == 2){
            $this->roleName = "Accountant";
            if($this->promoteTo=='Accountant'){
                session()->flash('error', 'Already an Accountant');
                return redirect(route('usersIndex'));
            }
        }elseif($user->role_id == 4){
            $this->roleName = "Member";
            if($this->promoteTo=='Member'){
                session()->flash('error', 'Already a Member');
                return redirect(route('usersIndex'));
            }
        }

        // dd($this->roleName);
                

        return view('livewire.manage-user.manage-user-index', with([
            'name' => $this->name,
            'roleName' => $this->roleName,
            'email' => $this->email,
            'phone' => $this->phone,
            'userId' => $this->userId,
            'password' =>  $this->password ,
        ]));    
    }

    public function promoteUser(){


        if( $this->promoteTo == "Member"){

        
        $this->validate([
            'name' => 'required|string|min:4|max:50',
            'role_id' => 'required|numeric',
            'email' => 'required|email',
            'phone' => 'required|digits:10',
            'society_id' => 'required|exists:societies,id|not_in:0',
            'password' => 'required|min:8',
            'is_rented' => 'nullable|in:Yes,No', // Optional, only Yes or No
            'room_number' => 'nullable|string',
        ]);

        if (!$this->checkMemberCountForSociety($this->society_id,$this->userId)){
            return redirect(route('membersIndex'))->with(['error' => 'Society is full']);
        }

        $user = User::find($this->selectedUsers[0]);
        // dd( $user->id,$this->name,$this->role_id,$this->email,$this->phone,$this->society_id,$this->room_number ?? '');
        
        $user->update([
            'name' => $this->name,
            'role_id' => 4,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        // Determine if the member is rented
        $isRented = $this->is_rented === 'Yes' ? '1' : '0';

        // Create the member
        Member::create([
            'user_id' => $user->id,
            'society_id' => $this->society_id,
            'is_rented' => $isRented,
            'room_number' => $this->room_number ?? '',
        ]);
        
    }else if( $this->promoteTo == "Accountant"){

        $this->validate([
            'role_id' => 'required|numeric',
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|email',
            'phone' => 'required|digits:10',
            'password' => 'required|min:8',
        ]);
        
        $user = User::find($this->selectedUsers[0]);

        // dd( $user->id,$this->name,$this->role_id,$this->email,$this->phone);
        $user->update([
            'name' => $this->name,
            'role_id' => 2,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);


        Accountant::create([
            'user_id' => $user->id,
        ]);


    }


        // Reset input fields
        $this->resetInputFields();

        // Redirect with success message
        return redirect(route('usersIndex'))->with(['success' => 'Promoted Successfully ']);
    }


    public function selectUser($userId)
    {
        if (in_array($userId, $this->selectedUsers)) {
            $this->selectedUsers = array_diff($this->selectedUsers, [$userId]);
        } else {
            $this->selectedUsers[] = $userId;
        }

    }

    public function checkMemberCountForSociety($society_id,$userId): bool
    {
      $currentMemberCount = Member::where('society_id', $society_id)->count();
      $society = Societies::where('id', $society_id)->first();
    
      if (is_null($society)) {
          // Handle the case where the society is not found (optional)
          return redirect(route('membersIndex'))->with(['error' => 'Society is full']); // Or throw an exception
      }
    
      $societyMemberCount = $society->member_count;

      $user = User::find($userId);
      $role = $user->role_id;

     
        if($currentMemberCount = $societyMemberCount){
            return false;
          } 
      
      
    
      return $currentMemberCount < $societyMemberCount;
    }


    public function render()
{
    $users = User::where('name', 'like', "%{$this->search}%")
        ->latest()
        ->paginate(5);

    $societies = Societies::all(); // Assuming it's Society model
    // dd($societies); // Uncomment for debugging

    return view('livewire.manage-user.manage-user-index', [
        'users' => $users,
        'societies' => $societies,
        'promoteTo' => $this->promoteTo,
    ])->with('button', 'Create new user');
}

}
