<?php

namespace App\Livewire\Societies;

use Livewire\Component;
use App\Models\Societies;

use App\Models\Member;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Carbon;

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

    public $upload;
    public $s_id;

    public $number = 1;

    public function mount()
    {
        $this->accountant_id = Auth::user()->id;
    }



    public function import()
    {
        // Validate the file upload
        $this->validate([
            'upload' => 'required|file|mimes:xlsx,xls'
        ]);

        // Store the uploaded file
        $filePath = $this->upload->storeAs('files', 'excel.xlsx');

        // Import societies from the uploaded file
        (new FastExcel)->import(storage_path('app/' . $filePath), function ($line) {
            return Societies::create([
                'name' => $line['name'],
                'phone' => $line['phone'],
                'address' => $line['address'],
                'bank_name' => $line['bank_name'],
                'bank_ifsc_code' => $line['bank_ifsc_code'],
                'bank_account_number' => $line['bank_account_number'],
                'member_count' => $line['member_count'],
                'president_name' => $line['president_name'],
                'vice_president_name' => $line['vice_president_name'],
                'secretary_name' => $line['secretary_name'],
                'treasurer_name' => $line['treasurer_name'],
                'accountant_id' => Auth::user()->id,
            ]);
        });

        return redirect('/accountant/manage/societies')->with([
            'success' => 'Society saved successfully'
        ]);
    }

    public function RegisteredMembers($id)
    {
        $society = Societies::findOrFail($id);
        return $society->members()->count();
    }




    /* $societies = (new FastExcel)->import(storage_path('app/files/'.'excel.xlsx'), function ($line) {
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
           }); */

    // ... 

    public function acceptPayment()
    {
        $data = [
            "merchantId" => "PGTESTPAYUAT",
            "merchantTransactionId" => "MT7850590068188104",
            "merchantUserId" => "MUID123",
            "amount" => $this->member_count * 120,
            "redirectUrl" => route('societies'),
            "redirectMode" => "REDIRECT",
            "callbackUrl" => 'https://webhook.site/callback-url',
            "mobileNumber" => "9999999999",
            "paymentInstrument" => [
                "type" => "PAY_PAGE"
            ]
        ];

        $encode = base64_encode(json_encode($data));

        $saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
        $saltIndex = 1;

        $string = $encode . '/pg/v1/pay' . $saltKey;
        $sha256 = hash('sha256', $string);

        $finalXHeader = $sha256 . '###' . $saltIndex;

        $url = "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay";

        $response = Curl::to($url)
            ->withHeader('Content-Type:application/json')
            ->withHeader('X-VERIFY:' . $finalXHeader)
            ->withData(json_encode(['request' => $encode]))
            ->post();

        $rData = json_decode($response);

        if (isset($rData->data->instrumentResponse->redirectInfo->url)) {
            // Dispatch an event with the payment data
            $this->dispatch('paymentInitiated', ['paymentData' => $rData]);

            $redirectUrl = $rData->data->instrumentResponse->redirectInfo->url;
            return redirect()->to($redirectUrl);
        } else {
            return redirect()->route('societies')->with('error', 'Payment initialization failed.');
        }
    }

    protected $listeners = ['paymentInitiated' => 'checkPaymentStatus'];

    public function checkPaymentStatus($paymentStatus)
    {
        // Check if the payment was successful
        if ($paymentStatus['success'] == true && $paymentStatus['code'] == 'PAYMENT_SUCCESS') {
            // If the payment was successful, save the data
            $this->save();
            return redirect()->route('societies')->with('success', 'Payment successful and data saved.');
        } else {
            // If the payment was not successful, redirect with an error message
            return redirect()->route('societies')->with('error', 'Payment failed or unsuccessful.');
        }
    }

    // public $update = false;

    public function updateSociety($id)
    {
        $society = societies::find($id);

        $this->s_id = $society->id;
        $this->name = $society->name;
        $this->phone = $society->phone;
        $this->address = $society->address;
        $this->bank_name = $society->bank_name;
        $this->bank_ifsc_code = $society->bank_ifsc_code;
        $this->bank_account_number = $society->bank_account_number;
        $this->member_count = $society->member_count;
        $this->president_name = $society->president_name;
        $this->vice_president_name = $society->vice_president_name;
        $this->secretary_name = $society->secretary_name;
        $this->treasurer_name = $society->treasurer_name;



        // $this->update = true;
    }

    public function upData()
    {

        // Assuming you have a Society model
        $society = Societies::findOrFail($this->s_id);
        $society->name = $this->name;
        $society->phone = $this->phone;
        $society->address = $this->address;
        $society->bank_name = $this->bank_name;
        $society->bank_ifsc_code = $this->bank_ifsc_code;
        $society->bank_account_number = $this->bank_account_number;
        $society->member_count = $this->member_count;
        $society->accountant_id = Auth::user()->id;
        $society->secretary_name = $this->secretary_name;
        $society->president_name = $this->president_name;
        $society->vice_president_name = $this->vice_president_name;
        $society->treasurer_name = $this->treasurer_name;
        // Update other properties as needed

        $society->save();
        $this->resetFilters();

        return redirect('/accountant/manage/societies')->with([
            'success' => 'Society Details Updated successfully'
        ]);
    }

    public function submit()
    {
        // Debugging output
        logger()->info('Submit method called');

        $this->validate([
            'name' => 'required',
            'phone' => 'required|digits:10',
            'address' => 'required',
            'member_count' => 'required',
            'bank_name' => 'required',
            'bank_ifsc_code' => 'required',
            'bank_account_number' => 'required',
            'president_name' => 'required',
            'vice_president_name' => 'required',
            'secretary_name' => 'required',
            'treasurer_name' => 'required',
        ]);

        $society = new Societies();
        $society->name = $this->name;
        $society->phone = $this->phone;
        $society->address = $this->address;
        $society->member_count = $this->member_count;
        $society->bank_name = $this->bank_name;
        $society->bank_ifsc_code = $this->bank_ifsc_code;
        $society->bank_account_number = $this->bank_account_number;
        $society->accountant_id = Auth::user()->id;
        $society->president_name = $this->president_name;
        $society->vice_president_name = $this->vice_president_name;
        $society->secretary_name = $this->secretary_name;
        $society->treasurer_name = $this->treasurer_name;
        $society->save();

        // Clear input fields after submission
        $this->resetFilters();

        return redirect('/accountant/manage/societies')->with([
            'success' => 'Society saved successfully'
        ]);
    }



    public function renewSociety($id)
    {
        $society = Societies::findOrFail($id);
        $society->renews_at = Carbon::now()->addYear();
        $society->save();

        return redirect('/accountant/manage/societies')->with([
            'success' => 'Society renewed successfully'
        ]);
    }

    // public function index()
    // {
    //     $societies = Societies::all()->map(function ($society) {
    //         $daysLeft = Carbon::now()->diffInDays(Carbon::parse($society->renews_at), false);
    //         $society->days_left = $daysLeft;
    //         return $society;
    //     });

    //     return view('societies.index', compact('societies'));
    // }




    public function resetFilters()
    {
        $this->reset(['name', 'phone', 'address', 'member_count', 'bank_name', 'bank_ifsc_code', 'bank_account_number', 'president_name', 'vice_president_name', 'secretary_name', 'treasurer_name']);
    }

    public function save()
    {
        //
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


        return redirect('/accountant/manage/societies')->with([
            'button' => 'Create new user',
            'success' => 'Society saved'
        ]);
    }

    // public function edit($id)
    // {
    //     $data = Societies::find($id);
    //     return view('livewire.societies.manage-societies-edit', [
    //         'data' => $data
    //     ]);
    // }


    // public function seeSociety($societyId)
    // {
    //     $society = Societies::findOrFail($societyId);

    //     if ($society->is_subscription_over) {
    //         // Handle subscription over logic here, like showing a message or redirecting elsewhere
    //         session()->flash('error', 'Subscription is over for this society.');
    //         return redirect()->back();
    //     } else {
    //         return redirect()->route('societyDetails', ['society' => $societyId]);
    //     }
    // }
    public function seeSociety($societyId)
    {
        $society = Societies::findOrFail($societyId);
        $daysLeft = Carbon::now()->diffInDays(Carbon::parse($society->renews_at), false);

        if ($daysLeft <= 0) {
            $this->dispatch('error', ['message' => 'Subscription is over for this society. Access denied.']);
        } else {
            return redirect()->route('societyDetails', ['society' => $societyId]);
        }
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function getRemainingDaysProgressBarWidth($daysLeft, $totalDays, $maxWidth = 100)
    {
        if ($totalDays == 0) {
            return 0;
        }

        $progressPercentage = ($daysLeft / $totalDays) * 100;
        $progressPercentage = min(100, $progressPercentage); // Ensure progress doesn't exceed 100%
        $progressWidth = $progressPercentage / 100 * $maxWidth;

        return $progressWidth;
    }

    



    public function render()
    {
        $societies = Societies::where('accountant_id', Auth::user()->id)->get();

        $societies = $societies->map(function ($society) {
            $daysLeft = Carbon::now()->diffInDays(Carbon::parse($society->renews_at), false);
            $society->days_left = $daysLeft;
            $society->is_subscription_over = $daysLeft <= 0;
            $society->show_renew_button = $society->is_subscription_over;
            $society->registered_members = $this->RegisteredMembers($society->id);
            $society->total_members = $society->member_count;
            return $society;
        });

        return view('livewire.societies.manage-societies-index', [
            'societies' => $societies,
        ]);
    }
}
