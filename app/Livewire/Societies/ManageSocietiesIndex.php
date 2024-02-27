<?php

namespace App\Livewire\Societies;

use Livewire\Component;
use App\Models\Societies;
use App\Models\Accountant;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Rap2hpoutre\FastExcel\Facades\FastExcel;

class ManageSocietiesIndex extends Component
{
    use WithFileUploads;

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

    public $excelFile;

    public function mount()
    {
        $this->accountant_id = Auth::user()->id;
    }

    public function import()
    {
        $fileName = time() . '.' . $this->excelFile->extension();

        $filePath = $this->excelFile->storeAs('uploads', $fileName);

        $societies = (new FastExcel)->import(storage_path($filePath), function ($line) {
            return Society::create([
                'name' => $line['name'],
                'phone' => $line['phone'],
                'address' => $line['address'],
                'bank_name' => $line['bank_name'],
                'bank_ifsc_code' => $line['bank_ifsc_code'],
                'bank_account_number' => $line['bank_account_number'],
                'member_count' => $line['member_count'],
                'accountant_id' => $line['accountant_id'],
            ]);
        });

        return redirect('/accountant/manage/societies');
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
        ])
            ->with([
                'button' => 'Create new user',
                'success' => 'Society saved'
            ]);
    }
}
