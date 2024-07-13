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
    public $upi_id = "";
    public $upi_number = "";
    public $parking_charges = "";
    public $maintenance_amount_owner = "";
    public $service_charges = "";
    public $maintenance_amount_rented = "";
    public $registered_balance = "";
    public $updated_balance = "";
    public $renews_at = "";
    public $showModal = false;


    use WithPagination;


    public $societies = "";

    public function mount()
    {
        $this->societies = Societies::all();
    }

    public function delete($id)
    {
        try {
            Societies::find($id)->delete();
            $this->societies = Societies::all();
        } catch (Exception) {
            return redirect(route('societiesIndex'))->with(['error' => 'Something went wrong. Try again later.']);
        }
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

        $this->s_id = $society->id;
        $this->name = $society->name;
        $this->phone = $society->phone;
        $this->address = $society->address;
        $this->member_count = $society->member_count;
        $this->bank_name = $society->bank_name;
        $this->bank_account_number = $society->bank_account_number;
        $this->bank_ifsc_code = $society->bank_ifsc_code;
        $this->accountant_id = $society->accountant_id;
        $this->renews_at = $society->renews_at;
        $this->upi_id = $society->upi_id;
        $this->upi_number = $society->upi_number;
        $this->parking_charges = $society->parking_charges;
        $this->maintenance_amount_owner = $society->maintenance_amount_owner;
        $this->service_charges = $society->service_charges;
        $this->maintenance_amount_rented = $society->maintenance_amount_rented;
        $this->registered_balance = $society->registered_balance;
        $this->updated_balance = $society->updated_balance;
        $this->showModal = true;


    }


    public function updateSociety()
    {
        // $this->validate();
        $this->validate([

            'name' => 'required|string|max:255',
            'phone' => 'required|digits:10', // Adjust based on phone number format requirements
            'address' => 'required|string',
            'member_count' => 'required|integer|min:0',
            'bank_name' => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:255',
            'bank_ifsc_code' => 'required|string|max:255',
            'accountant_id' => 'required|integer|exists:accountants,id',
            'upi_id' => 'nullable|string',
            'upi_number' => 'nullable|string',
            'parking_charges' => 'nullable|numeric|min:0',
            'maintenance_amount_owner' => 'nullable|numeric|min:0',
            'service_charges' => 'nullable|numeric|min:0',
            'maintenance_amount_rented' => 'nullable|numeric|min:0',
            'registered_balance' => 'nullable|numeric',
            'updated_balance' => 'nullable|numeric',
            'renews_at' => 'required|date_format:Y-m-d',
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
            'renews_at' => $this->renews_at,
            'upi_id' => $this->upi_id,
            'upi_number' => $this->upi_number,
            'parking_charges' => $this->parking_charges,
            'maintenance_amount_owner' => $this->maintenance_amount_owner,
            'service_charges' => $this->service_charges,
            'maintenance_amount_rented' => $this->maintenance_amount_rented,
            'registered_balance' => $this->registered_balance,
            'updated_balance' => $this->updated_balance,
        ]);

        $this->resetInputFields();
        // session()->flash('success', 'Society updated successfully.');

        $this->showModal = false;

        // Emit a browser event to refresh the page
        return redirect()->route('societiesIndex')->with(['success' => 'Society updated successfully.']);
    }


    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|digits:10', // Adjust based on phone number format requirements
            'address' => 'required|string',
            'member_count' => 'required|integer|min:0',
            'bank_name' => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:255|unique:societies,bank_account_number',
            'bank_ifsc_code' => 'required|string|max:255',
            'accountant_id' => 'required|integer|exists:accountants,id',
            'upi_id' => 'nullable|string|unique:societies,upi_id',
            'upi_number' => 'nullable|string|unique:societies,upi_number',
            'parking_charges' => 'nullable|numeric|min:0',
            'maintenance_amount_owner' => 'nullable|numeric|min:0',
            'service_charges' => 'nullable|numeric|min:0',
            'maintenance_amount_rented' => 'nullable|numeric|min:0',
            'registered_balance' => 'nullable|numeric',
            'updated_balance' => 'nullable|numeric',
            'renews_at' => 'required|date_format:Y-m-d',

        ]);

        Societies::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'address' => $this->address,
            'member_count' => $this->member_count,
            'bank_name' => $this->bank_name,
            'bank_account_number' => $this->bank_account_number,
            'bank_ifsc_code' => $this->bank_ifsc_code,
            'accountant_id' => $this->accountant_id,
            'renews_at' => $this->renews_at,
            'upi_id' => $this->upi_id,
            'upi_number' => $this->upi_number,
            'parking_charges' => $this->parking_charges,
            'maintenance_amount_owner' => $this->maintenance_amount_owner,
            'service_charges' => $this->service_charges,
            'maintenance_amount_rented' => $this->maintenance_amount_rented,
            'registered_balance' => $this->registered_balance,
            'updated_balance' => $this->updated_balance,

        ]);

        // session()->flash('success', 'Society created successfully.');
        return redirect()->route('societiesIndex')->with(['success' => 'Society created successfully.']);

    }


    public function render()
    {

        $societies = Societies::where('name', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(2);

        $user = User::find($this->accountant_id);

        $accountants = Accountant::with('user')->get();

        return view('livewire.manage-user.manage-society-index', [
            'societies' => $societies,
            'users' => $user,
            'accountants' => $accountants,
        ])->with('button', 'Create new society');
    }


}
