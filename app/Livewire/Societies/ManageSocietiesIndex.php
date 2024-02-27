<?php

namespace App\Livewire\Societies;

use Livewire\Component;
use App\Models\Societies;
use App\Models\Accountant;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

class ManageSocietiesIndex extends Component
{

    #[Title('Manage societies - mySocietyERP')]

    public $societyOptions;

    #[Validate('required')]
    public $name = '';

    #[Validate('required')]
    public $phone = '';

    #[Validate('required')]
    public $address = '';

    #[Validate('required')]
    public $bank_name = '';

    #[Validate('required')]
    public $bank_ifsc_code = '';

    #[Validate('required')]
    public $bank_account_number = '';

    #[Validate('required|integer')]
    public $member_count = '';

    #[Validate('required')]
    public $accountant_id = '';




    public $president_name = '';
    public $vice_president_name = '';
    public $treasurer_name = '';
    public $secretary_name = '';

    public function mount()
{
    $this->accountant_id = Auth::user()->id;
}

    public function save()
    {
        $this->validate();

        Societies::create($this->only([
            'name',
            'phone',
            'address',
            'member_count',
            'bank_name',
            'bank_ifsc_code',
            'bank_account_number',
            'accountant_id',
        ]));


        return $this->redirect('/accountant/manage/societies');
    }

    public function render()
    {

        return view('livewire.societies.manage-societies-index', [
            'societies' => Societies::latest()->where('accountant_id', Auth::user()->id)->paginate(5),
            'accountant_id' => Auth::user()->id,
        ])
            ->with([
                'button' => 'Create new user',
                'success' => 'Society saved'
            ]);
    }
}
