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
use Auth;
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

        $data = [
            'member' => $member,
            'bill' => $bill,
            'society' => $society,
        ];

        $pdf = Pdf::loadView('pdfs.invoice', $data);
        return $pdf->download('invoice.pdf');
    }

    public function processPayment(Request $request)
    {
        $billId = $request->input('bill_id');
        $bill = MaintenanceBill::findOrFail($billId);
    
        // Here you would integrate with a payment gateway
        // For this example, we'll just mark the bill as paid
    
        $bill->status = 1; // Assuming 1 means paid
        $bill->save();
    
        // Create a new payment record
        $payment = new Payment();
        $payment->maintenance_bills_id = $bill->id;
        $payment->amount_paid = $bill->amount; // Assuming the full amount is paid
        $payment->payment_date = Carbon::now();
        $payment->save();
    
        // Associate the payment with the bill
        $bill->payment()->save($payment);
    
        // Create a new receipt record
        $receipt = new Receipts();
        $receipt->payment_id = $payment->id;
        $receipt->save();
    
        return redirect()->back()->with('success', 'Payment processed successfully!');
    }

    public function downloadReceipt($paymentId)
    {
        $payment = Payment::with(['maintenanceBill.member.society', 'maintenanceBill.member.user'])
            ->findOrFail($paymentId);
    
        $bill = $payment->maintenanceBill;
        $member = $bill->member;
        $society = $member->society;
    
        $data = [
            'payment' => $payment,
            'bill' => $bill,
            'member' => $member,
            'society' => $society,
        ];
    
        $pdf = PDF::loadView('pdfs.receipt', $data);
    
        return $pdf->download('receipt_' . $paymentId . '.pdf');
    }
}