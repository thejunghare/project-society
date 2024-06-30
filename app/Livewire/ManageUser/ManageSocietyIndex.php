<?php

namespace App\Livewire\ManageUser;

use Exception;
use App\Models\Societies;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;

class ManageSocietyIndex extends Component
{
    #[Rule('required|string')]
    #[Title('Manage Societies - Society')]

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


    public $societies;

    public function mount()
    {
        $this->societies = Societies::all();
    }

    public function delete($id)
    {
        Societies::find($id)->delete();
        $this->societies = Societies::all();

        return redirect()->route('societiesIndex');
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
        'address' => 'required|string|max:255',
        'member_count' => 'required|integer',
        'bank_name' => 'required|string|max:255',
        'bank_account_number' => 'required|string|max:20',
        'bank_ifsc_code' => 'required|string|max:11',
        'accountant_id' => 'required|integer|exists:accountants,id',
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
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'member_count' => 'required|integer',
            'bank_name' => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:20',
            'bank_ifsc_code' => 'required|string|max:11',
            'accountant_id' => 'required|integer|exists:accountants,id',
        ]);

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
        session()->flash('message', 'Society updated successfully.');

        $this->showModal = false;

        // Emit a browser event to refresh the page
        return redirect()->route('societiesIndex');
    }

    public function save()
    {
        // $this->validate([
        //     'name' => 'required|string|max:255',
        //     'phone' => 'required|string|max:15',
        //     'address' => 'required|string|max:255',
        //     'member_count' => 'required|integer',
        //     'bank_name' => 'required|string|max:255',
        //     'bank_account_number' => 'required|string|max:20',
        //     'bank_ifsc_code' => 'required|string|max:11',
        //     'accountant_id' => 'required|integer|exists:accountants,id',
        // ]);

        Societies::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
            'member_count' => $this->member_count,
            'bank_name' => $this->bank_name,
            'bank_account_number' => $this->bank_account_number,
            'bank_ifsc_code' => $this->bank_ifsc_code,
            'accountant_id' => $this->accountant_id,
        ]);

        session()->flash('message', 'Society created successfully.');
        return redirect()->route('societiesIndex');
    }


    public function render()
    {
        $users = Societies::where('name', 'like', "%{$this->search}%")
            ->latest()
            ->paginate(5);

        return view('livewire.manage-user.manage-society-index', [
            'users' => $users,
        ])->with('button', 'Create new user');
    }


}
