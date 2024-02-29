<?php

namespace App\Livewire\Societies;

use Livewire\Component;
use App\Models\Societies;
use Illuminate\Http\Request;

use Ixudra\Curl\Facades\Curl;
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

    public $upload;

    public function mount()
    {
        $this->accountant_id = Auth::user()->id;
    }

    public function import()
    {
        $this->upload->store('excel', 'files');
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


        return redirect('/accountant/manage/societies')->with([
            'button' => 'Create new user',
            'success' => 'Society saved'
        ]);
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
