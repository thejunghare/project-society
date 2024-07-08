<?php

namespace App\Livewire\ManageUser;

use Exception;
use App\Models\Societies;
use App\Models\Accountant;
use App\Models\Member;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;

class ManageSocietyIndex extends Component
{
    #[Rule('required|string')]
    #[Title('Manage Societies')]

    // create user properties
    public $search = "";
    public $s_id = "";
    public $name = "";
    public $phone = "";
    public $address = "";
    public $member_count = "";
    public $bank_name = "";
    public $bank_account_number = "";
    public $bank_ifsc_code = "";
    public $accountant_id = "";
    public $showModal = false;
    

    use WithPagination;


    public $societies = "";

    public function mount()
    {
        $this->societies = Societies::all();
    }

    public function delete($id)
    {
        Societies::find($id)->delete();
        $this->societies = Societies::all();

        return redirect()->route('societiesIndex')->with(['success' => 'Society Deleted successfully.']);
    }

    protected $rules = [
        // 'name' => 'required|string|max:255',
        // 'phone' => 'required|digits:10',
        // 'address' => 'required|string|max:255',
        // 'member_count' => 'required|integer',
        // 'bank_name' => 'required|string|max:255',
        // 'bank_account_number' => 'required|max:20',
        // 'bank_ifsc_code' => 'required|max:11',
        // 'accountant_id' => 'required|exists:accountants,id',
    ];

    private function resetInputFields()
    {


        $this->s_id = null;
        $this->name = '';
        $this->phone = '';
        $this->address = '';
        $this->member_count = '';
        $this->bank_name = '';
        $this->bank_account_number = '';
        $this->bank_ifsc_code = '';
        $this->accountant_id = '';

        $this->showModal = false;
    }

    public function edit($id)
    {
        $society = Societies::findOrFail($id);
        
        $this->updateMemberCountForSociety($id);
        
        $this->s_id = $society->id;
        $this->name = $society->name;
        $this->phone = $society->phone;
        $this->address = $society->address;
        $this->member_count = $society->member_count;
        $this->bank_name = $society->bank_name;
        $this->bank_account_number = $society->bank_account_number;
        $this->bank_ifsc_code = $society->bank_ifsc_code;
        $this->accountant_id = $society->accountant_id;
        $this->showModal = true;


    }


    public function updateSociety()
    {
        // $this->validate();

        $society = Societies::findOrFail($this->s_id);
        $society->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
            'member_count' => $this->member_count,
            'bank_name' => $this->bank_name,
            'bank_account_number' => $this->bank_account_number,
            'bank_ifsc_code' => $this->bank_ifsc_code,
            'accountant_id' => $this->accountant_id,
        ]);

        $this->resetInputFields();
        // session()->flash('success', 'Society updated successfully.');

        $this->showModal = false;

        // Emit a browser event to refresh the page
        return redirect()->route('societiesIndex')->with(['success' => 'Society updated successfully.']);
    }


    public function updateMemberCountForSociety($society_id)
    {
        $memberCount = Member::where('society_id', $society_id)->count();
        Societies::where('id', $society_id)->update(['member_count' => $memberCount]);
    }

    public function save()
    {
         $this->validate([
             'name' => 'required|string',
             'phone' => 'required|digits:10',
             'address' => 'required',
             'bank_name' => 'required',
             'bank_account_number' => 'required',
             'bank_ifsc_code' => 'required',
             'accountant_id' => 'required|exists:accountants,id',
         ]);

        Societies::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
            'member_count' => 0,
            'bank_name' => $this->bank_name,
            'bank_account_number' => $this->bank_account_number,
            'bank_ifsc_code' => $this->bank_ifsc_code,
            'accountant_id' => $this->accountant_id,
        ]);

        // session()->flash('success', 'Society created successfully.');
        return redirect()->route('societiesIndex')->with(['success' => 'Society created successfully.']);
        
    }


    public function render()
    {
        
        $societies = Societies::where('name', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(2);

        $users= User::all();
        $accountants = Accountant::with('user')->get();

        return view('livewire.manage-user.manage-society-index', [
            'societies' => $societies,
            'users' => $users,
            'accountants' => $accountants,
        ])->with('button', 'Create new society');
    }


}
