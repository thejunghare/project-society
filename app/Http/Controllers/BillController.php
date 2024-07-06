<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceBill;
use App\Models\Member;
use Auth;
use Carbon\Carbon;

class BillController extends Controller
{
    public function showPayBillPage()
    {
        $user = Auth::user();
        $member = Member::where('user_id', $user->id)->first();

        $currentDate = Carbon::now();

        $bills = MaintenanceBill::where('member_id', $member->id)
            ->where('status', 0) // Assuming 0 means unpaid
            ->orderBy('due_date', 'asc')
            ->get()
            ->map(function ($bill) use ($currentDate) {
                $bill->is_overdue = $currentDate->gt(Carbon::parse($bill->due_date));
                $bill->due_date = Carbon::parse($bill->due_date);
                return $bill;
            });

        $totalDue = $bills->sum('amount');

        return view('pay-bill', compact('user', 'member', 'bills', 'totalDue'));
    }

    public function processPayment(Request $request)
    {
        $billId = $request->input('bill_id');
        $bill = MaintenanceBill::findOrFail($billId);

        // Here you would integrate with a payment gateway
        // For this example, we'll just mark the bill as paid

        $bill->status = 1; // Assuming 1 means paid
        $bill->save();

        return redirect()->back()->with('success', 'Payment processed successfully!');
    }
}