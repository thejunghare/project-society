<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceBill;
use App\Models\Member;
use App\Models\Societies;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;
use App\Models\Payment;
use App\Models\Receipts;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Storage;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Helpers\AmountHelper;
use Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BillController extends Controller
{
    #[Title('Pay Bill')]
    public function showPayBillPage()
    {
        $user = Auth::user();
        $member = Member::where('user_id', $user->id)->first();

        $currentDate = Carbon::now();

        $bills = MaintenanceBill::where('member_id', $member->id)
            ->orderBy('due_date', 'desc')
            ->get()
            ->map(function ($bill) use ($currentDate) {
                $bill->is_overdue = $currentDate->gt(Carbon::parse($bill->due_date));
                $bill->due_date = Carbon::parse($bill->due_date);
                return $bill;
            });

        $unpaidBills = $bills->where('status', 0);
        $paidBills = $bills->where('status', 1);

        $totalDue = $unpaidBills->sum('amount');

        return view('pay-bill', compact('user', 'member', 'unpaidBills', 'paidBills', 'totalDue'));
    }

    public function downloadInvoice($billId)
    {
        $bill = MaintenanceBill::with('member.user')->findOrFail($billId);
        $member = $bill->member;
        $society = Societies::where('id', $member->society_id)->firstOrFail();

        // Get the current payment for this bill
        $currentPayment = Payment::where('maintenance_bills_id', $billId)->first();

        // Get the most recent previous payment for this member
        $previousPayment = Payment::where('maintenance_bills_id', '<>', $billId)
            ->whereHas('maintenanceBill', function ($query) use ($member) {
                $query->where('member_id', $member->id);
            })
            ->orderBy('payment_date', 'desc')
            ->first();

        $maintenanceAmount = $member->is_rented ? $member->society->maintenance_amount_rented : $member->society->maintenance_amount_owner;

        $lateFee = 0;
            if ($bill->late_fee_applied) {
                $lateFee = $member->society->late_fee;
            }

        $data = [
            'member' => $member,
            'bill' => $bill,
            'society' => $society,
            'currentPayment' => $currentPayment,
            'previousPayment' => $previousPayment,
            'maintenance_amount' => $maintenanceAmount,
            'late_fee' => $lateFee,
        ];

        $pdf = Pdf::loadView('pdfs.invoice', $data);
        return $pdf->download('invoice.pdf');
    }
    public function downloadReceipt($paymentId)
    {
        $currentPayment = Payment::with(['maintenanceBill.member.society', 'maintenanceBill.member.user'])
            ->findOrFail($paymentId);

        $bill = $currentPayment->maintenanceBill;
        $member = $bill->member;
        $society = $member->society;
        $amountInWords = AmountHelper::amountToWords($currentPayment->amount_paid);

        $data = [
            'currentPayment' => $currentPayment,
            'bill' => $bill,
            'member' => $member,
            'society' => $society,
            'amountInWords' => $amountInWords,
            'payment_mode_id' => $bill->payment_mode_id,
            'reference_no' => $currentPayment ? $currentPayment->reference_no : null,
            'transaction_id' => $currentPayment ? $currentPayment->transaction_id : null,
        ];

        $pdf = Pdf::loadView('pdfs.receipt', $data);

        return $pdf->download('receipt_' . $paymentId . '.pdf');
    }


    public function processPayment(Request $request)
    {
        $billId = $request->input('bill_id');
        $bill = MaintenanceBill::findOrFail($billId);

        $user = Auth::user();
        $member = Member::where('user_id', $user->id)->first();

        $data = $this->preparePaymentData($user, $bill);

        // Debugging data
        \Log::info('Payment data: ', $data);

        $encode = base64_encode(json_encode($data));

        $saltKey = '96434309-7796-489d-8924-ab56988a6076'; // Use environment variable
        $saltIndex = 1;

        $url = "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay";

        $maxAttempts = 5;
        $attempt = 0;

        do {
            try {
                $string = $encode . '/pg/v1/pay' . $saltKey;
                $sha256 = hash('sha256', $string);
                $finalXHeader = $sha256 . '###' . $saltIndex;

                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'X-VERIFY' => $finalXHeader
                ])->withOptions([
                    'verify' => storage_path('cacert.pem')
                ])->post($url, [
                    'request' => $encode
                ]);

                $rData = $response->json();

                // Log the response for debugging
                \Log::info('PhonePe API response: ', $rData);

                if (isset($rData['data']['instrumentResponse']['redirectInfo']['url'])) {
                    // Store payment initiation data in session
                    session([
                        'payment_data' => [
                            'bill_id' => $billId,
                            'transaction_id' => $data['merchantTransactionId'],
                            'amount' => $bill->amount
                        ]
                    ]);

                    $redirectUrl = $rData['data']['instrumentResponse']['redirectInfo']['url'];
                    return response()->json(['redirect_url' => $redirectUrl]);
                } else {
                    if (isset($rData['code']) && $rData['code'] === 'TOO_MANY_REQUESTS' && $attempt < $maxAttempts) {
                        \Log::warning('Rate limit hit, retrying... Attempt: ' . ($attempt + 1));
                        sleep(2 ** $attempt); // Exponential backoff with increased delay
                        $attempt++;
                    } else {
                        \Log::error('Payment initialization failed: ', $rData);
                        return response()->json(['error' => 'Payment initialization failed.'], 400);
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Error initializing payment: ', ['message' => $e->getMessage()]);
                return response()->json(['error' => 'Payment initialization failed due to an error.'], 500);
            }
        } while ($attempt < $maxAttempts);

        return response()->json(['error' => 'Too many requests. Please try again later.'], 429);
    }

    private function preparePaymentData($user, $bill)
    {
        return [
            "merchantId" => "PGTESTPAYUAT86",
            "merchantTransactionId" => Str::uuid()->toString(),
            "merchantUserId" => $user->id,
            "amount" => $bill->amount * 100, // Amount in paise
            "redirectUrl" => route('payment.callback'),
            "redirectMode" => "REDIRECT",
            "callbackUrl" => route('payment.callback'),
            "mobileNumber" => $user->phone_number ?? "9999999999",
            "paymentInstrument" => [
                "type" => "PAY_PAGE"
            ]
        ];
    }
    public function handlePaymentCallback(Request $request)
    {
        $paymentData = session('payment_data');

        if (!$paymentData) {
            return redirect()->route('pay.bill')->with('error', 'Invalid payment session.');
        }

        $transactionId = $paymentData['transaction_id'];
        $paymentStatus = $this->verifyPaymentWithPhonePe($transactionId);

        if ($paymentStatus['code'] === 'PAYMENT_SUCCESS') {
            $bill = MaintenanceBill::findOrFail($paymentData['bill_id']);

            // Update bill status
            $bill->status = 1; // Paid
            $bill->payment_mode_id = 1;
            $bill->save();
            // Create payment record
            $payment = new Payment();
            $payment->maintenance_bills_id = $bill->id;
            $payment->amount_paid = $paymentData['amount'];
            $payment->payment_date = Carbon::now();
            $payment->transaction_id = $paymentData['transaction_id'];
            $payment->save();

            // Create receipt
            $receipt = new Receipts();
            $receipt->payment_id = $payment->id;
            $receipt->save();



            // Update the updated_balance field in the Society table
            $member = $bill->member;
            if ($member && $member->society) {
                $society = $member->society;
                $paymentAmount = (float) $paymentData['amount'];
                $society->updated_balance = $society->updated_balance + $paymentAmount;
                $society->save();

                \Log::info('Society balance updated. New balance: ' . $society->updated_balance);
            } else {
                if (!$member) {
                    \Log::error('Member not found for bill ID: ' . $bill->id);
                } elseif (!$member->society) {
                    \Log::error('Society not found for member ID: ' . $member->id);
                }
                // Here you might want to add some error handling or notification
            }

            // Clear the payment data from session
            session()->forget('payment_data');

            return redirect()->route('pay.bill')->with('success', 'Payment successful and bill updated.');
        } elseif ($paymentStatus['code'] === 'PAYMENT_PENDING') {
            // Retry logic for pending transactions
            return redirect()->route('pay.bill')->with('success', 'Payment successful and bill updated.');
        } else {
            return redirect()->route('pay.bill')->with('error', 'Payment failed or was unsuccessful.');
        }
    }



    private function updateBillAndCreateRecords($bill, $paymentData)
    {
        // Update bill status
        $bill->status = 1; // Paid
        $bill->save();

        // Create payment record
        $payment = new Payment();
        $payment->maintenance_bills_id = $bill->id;
        $payment->amount_paid = $paymentData['amount'];
        $payment->payment_date = Carbon::now();
        $payment->transaction_id = $paymentData['transaction_id'];
        $payment->save();

        // Create receipt
        $receipt = new Receipts();
        $receipt->payment_id = $payment->id;
        $receipt->save();

        // Clear the payment data from session
        session()->forget('payment_data');
    }

    private function retryPaymentVerification($paymentData)
    {
        $maxRetries = 5;
        $retryInterval = 2; // Starting with 2 seconds
        $attempt = 0;

        while ($attempt < $maxRetries) {
            sleep($retryInterval);

            $paymentStatus = $this->verifyPaymentWithPhonePe($paymentData['transaction_id']);
            if ($paymentStatus['code'] === 'PAYMENT_SUCCESS') {
                // Update bill status and create payment records
                $this->updateBillAndCreateRecords($paymentData['bill_id'], $paymentData);

                return redirect()->route('pay.bill')->with('success', 'Payment successful and bill updated.');
            } elseif ($paymentStatus['code'] === 'PAYMENT_FAILED') {
                return redirect()->route('pay.bill')->with('error', 'Payment failed or was unsuccessful.');
            }

            $retryInterval *= 2; // Exponential backoff
            $attempt++;
        }

        return redirect()->route('pay.bill')->with('info', 'Payment is pending. Please check back later for status update.');
    }


    private function verifyPaymentWithPhonePe($transactionId)
    {
        $merchantId = "PGTESTPAYUAT86";
        $saltKey = '96434309-7796-489d-8924-ab56988a6076';
        $saltIndex = 1;

        $urlPath = "/pg/v1/status/{$merchantId}/{$transactionId}";
        $url = "https://api-preprod.phonepe.com/apis/pg-sandbox" . $urlPath;
        $stringToHash = $urlPath . $saltKey;
        $sha256 = hash('sha256', $stringToHash);
        $finalXHeader = $sha256 . '###' . $saltIndex;
        $clientId = $merchantId;

        \Log::info('Verifying payment with PhonePe', [
            'url' => $url,
            'headers' => [
                'Content-Type' => 'application/json',
                'X-VERIFY' => $finalXHeader,
                'X-CLIENT-ID' => $clientId
            ]
        ]);

        try {
            $response = Http::withoutVerifying()->withHeaders([
                'Content-Type' => 'application/json',
                'X-VERIFY' => $finalXHeader,
                'X-CLIENT-ID' => $clientId
            ])->get($url);

            $rData = $response->json();

            \Log::info('PhonePe API verification response: ', $rData);

            if ($response->successful()) {
                switch ($rData['code']) {
                    case 'PAYMENT_SUCCESS':
                        return ['code' => 'PAYMENT_SUCCESS'];
                    case 'PAYMENT_PENDING':
                        return ['code' => 'PAYMENT_PENDING'];
                    case 'PAYMENT_ERROR':
                    case 'PAYMENT_DECLINED':
                    case 'PAYMENT_CANCELLED':
                        return ['code' => 'PAYMENT_FAILED'];
                    default:
                        return ['code' => 'PAYMENT_FAILED'];
                }
            } else {
                \Log::error('PhonePe API verification error: ', $rData);
                return ['code' => 'PAYMENT_FAILED'];
            }
        } catch (\Exception $e) {
            \Log::error('Error verifying payment: ', ['message' => $e->getMessage()]);
            return ['code' => 'PAYMENT_FAILED'];
        }
    }
}
