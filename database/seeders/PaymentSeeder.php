<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaintenanceBill;
use App\Models\Payment;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        $maintenanceBills = MaintenanceBill::all();

        foreach ($maintenanceBills as $bill) {
            // Determine if the bill should be paid based on its status
            if ($bill->status == 0) { // Assuming 0 means unpaid
                // 70% chance of creating a payment for unpaid bills
                if (rand(1, 100) <= 70) {
                    $this->createPayment($bill);
                }
            } else {
                // Always create a payment for bills marked as paid
                $this->createPayment($bill);
            }
        }
    }

    private function createPayment($bill)
    {
        $paymentDate = $this->getPaymentDate($bill->due_date);
        $amountPaid = $this->getAmountPaid($bill->amount);

        Payment::create([
            'maintenance_bills_id' => $bill->id,
            'amount_paid' => $amountPaid,
            'payment_date' => $paymentDate,
        ]);

        // Update bill status if fully paid
        if ($amountPaid >= $bill->amount) {
            $bill->update(['status' => 1]); // Assuming 1 means paid
        }
    }

    private function getPaymentDate($dueDate)
    {
        $dueDate = Carbon::parse($dueDate);
        $today = Carbon::today();

        if ($dueDate->isFuture()) {
            // If due date is in the future, payment date is between today and 30 days ago
            return Carbon::today()->subDays(rand(0, 30));
        } else {
            // If due date is in the past, payment date is between due date and today
            return Carbon::createFromTimestamp(rand($dueDate->timestamp, $today->timestamp));
        }
    }

    private function getAmountPaid($billAmount)
    {
        // 80% chance of paying full amount, 20% chance of partial payment
        if (rand(1, 100) <= 80) {
            return $billAmount;
        } else {
            // Partial payment between 50% and 99% of bill amount
            return round($billAmount * (rand(50, 99) / 100), 2);
        }
    }
}