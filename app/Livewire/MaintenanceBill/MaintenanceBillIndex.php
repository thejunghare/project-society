<?php

namespace App\Livewire\MaintenanceBill;
use DateTime;
use App\Models\Member;
use Carbon\Carbon;
use App\Livewire\DatePicker;
use App\Models\Societies;
use Livewire\Component;
use Twilio\Rest\Client;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Models\MaintenanceBill;
use App\Helpers\AmountHelper;
use App\Models\Payment;
use ZipArchive;
use App\Models\Receipts;
use Barryvdh\DomPDF\Facade\Pdf;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaintenanceBillIndex extends Component
{
    use WithPagination, WithoutUrlPagination;

    #[Title("Maintenance Bill - mySocietyERP")]
    public $society;
    public $societiesList;
    public $months;
    public $search;
    public $selected_society;
    public $selected_year;
    public $selected_month;
    public $members;
    public $selectedMembers = [];
    public $selectAll = false;
    public $amount;
    public $due_date;

    public $editingBillId = null;
    public $editPaymentStatus;
    public $editPaymentMode;
    public $editAdvance;
    public $isEditModalOpen = false;

    public $isModalOpen = false;
    public $selectedBillIndex;
    public $selectedBills = [];

    public function mount(Societies $society)
    {
        $this->society = $society;
        $this->societiesList = Societies::where(
            "accountant_id",
            Auth::user()->id
        )->pluck("name", "id");
        $this->months = $this->returnMonths();
        $this->members = collect();
        $this->selected_society = $society->id;
    }

    public function goBack()
    {
        return redirect(
            "/accountant/manage/societies/" .
                $this->society->id .
                "/society-details"
        );
    }

    public $editingBill;
    public $editName;
    public $editPaymentMethod;
    public $editAdvancePayment;
    public $editChequeNo;
    public $asdid;
    public $editRemark;

    public function openEditModal($billId)
    {
        $this->editingBillId = $billId;
        $this->dispatch("open-modal");
        $this->editingBill = MaintenanceBill::with("member.user")->findOrFail(
            $billId
        );
        $this->editName = $this->editingBill->member->user->name;
        $this->editPaymentMethod = $this->editingBill->payment_mode_id;
        $this->asdid = $this->editingBill->id;
        $this->editRemark = $this->editingBill->remark;
        $this->editAdvancePayment = $this->editingBill->advance ? "1" : "0";
        $this->editChequeNo = $this->editingBill->payment
            ? $this->editingBill->payment->reference_no
            : "";
        $this->isModalOpen = true;
    }

    public function closeEditModal()
    {
        $this->isModalOpen = false;
        $this->resetEditFields();
    }

    public function resetEditFields()
    {
        $this->reset([
            "editingBill",
            "editName",
            "editPaymentMethod",
            "editRemark",
            "editChequeNo",
            "editAdvancePayment",
        ]);
        // $this->editingBill = null;
        // $this->editName = '';
        // $this->editPaymentMethod = '';
        // $this->editRemark = '';
        // $this->editChequeNo = '';
        // $this->editAdvancePayment = '';
    }

    public function updateBill()
    {
        // Validate form inputs
        $validatedData = $this->validate([
            "editName" => "required|string|max:255",
            "editPaymentMethod" => "required",
            "editAdvancePayment" => "required",
        ]);

        $originalStatus = $this->editingBill->getOriginal("status");
        $newStatus = 1;

        // Update member's user name
        $this->editingBill->member->user->update([
            "name" => $this->editName,
        ]);

        $this->editingBill->advance =
            $this->editAdvancePayment === "1" ||
            $this->editAdvancePayment === 1;
        $this->editPaymentMethod = $this->editPaymentMethod;
        $this->editingBill->remark = $this->editRemark;

        // Use the amount from the maintenance bills table
        $amountToPay = $this->editingBill->amount ?? 0;

        // Check if a payment entry exists
        $payment = Payment::where(
            "maintenance_bills_id",
            $this->editingBill->id
        )->first();

        // Check if a payment entry exists
        if (!$payment) {
            // Create a new payment entry
            $payment = new Payment();
            $payment->maintenance_bills_id = $this->editingBill->id;
            $payment->amount_paid = $amountToPay;
            $payment->payment_date = now();
            $payment->transaction_id = ""; // You may want to generate a unique transaction ID here
            $payment->save();
            // Create a new receipt
            if (in_array($this->editPaymentMethod, [1, 2])) {
                $payment->reference_no = $this->editChequeNo;
            } else {
                $payment->reference_no = ""; // Clear cheque number if payment method is not cheque and online
            }

            $receipt = new Receipts();
            $receipt->payment_id = $payment->id;
            $receipt->save();

            // Set the status to 1 (paid)
            $this->editingBill->status = 1;
        }
        if (in_array($this->editPaymentMethod, [1, 2])) {
            // Online or Cheque
            $payment->reference_no = $this->editChequeNo;
        } else {
            // Cash or any other method
            $payment->reference_no = null;
        }
        // Update existing payment entry
        $payment->update([
            "amount_paid" => $amountToPay,
            "payment_date" => now(),
            // 'reference_no' => $this->editPaymentMethod == 2 || $this->editPaymentMethod == 1 ? $this->editChequeNo : null, // Update cheque number
        ]);

        // Check if a receipt already exists for this payment
        $receipt = Receipts::where("payment_id", $payment->id)->first();
        if (!$receipt) {
            // Create a new receipt if it doesn't exist
            $receipt = new Receipts();
            $receipt->payment_id = $payment->id;
            $receipt->save();
        }

        // Set the status to 1 (paid) if it's not already
        $this->editingBill->status = 1;

        // Update maintenance bill details
        $this->editingBill->update([
            "payment_mode_id" => $this->editPaymentMethod,
            "advance" => $this->editAdvancePayment == "1",
            "status" => 1, // Ensure status is set to 1 (paid)
        ]);

        if (in_array($this->editPaymentMethod, [1, 2])) {
            $payment->reference_no = $this->editChequeNo;
        } else {
            $payment->reference_no = ""; // Clear cheque number if payment method is not cheque and online
        }

        // Save the changes
        $this->editingBill->save();

        // Update society balance only if status changed from 0 to 1
        if ($originalStatus == 0 && $newStatus == 1) {
            $member = $this->editingBill->member;
            if ($member && $member->society) {
                $society = $member->society;
                $paymentAmount = (float) $amountToPay;

                try {
                    $society->updated_balance =
                        $society->updated_balance + $paymentAmount;
                    $society->save();
                    \Log::info(
                        "Society balance updated. New balance: " .
                            $society->updated_balance
                    );
                } catch (\Exception $e) {
                    \Log::error(
                        "Error updating society balance: " . $e->getMessage()
                    );
                }
            } else {
                if (!$member) {
                    \Log::error(
                        "Member not found for bill ID: " .
                            $this->editingBill->id
                    );
                } elseif (!$member->society) {
                    \Log::error(
                        "Society not found for member ID: " . $member->id
                    );
                }
                // Here you might want to add some error handling or notification
            }
        } else {
            \Log::info(
                "Society balance not updated. Status did not change from unpaid to paid."
            );
        }

        // Close the edit modal after updating
        $this->closeEditModal();

        session()->flash("success", "The bill has been successfully updated!");
    }

    public function returnMonths()
    {
        return [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December",
        ];
    }

    public function exportMembersBillsToExcel()
    {
        if ($this->selected_society && $this->selected_year && $this->selected_month) {
            $membersBills = Member::join('maintenance_bills', 'members.id', '=', 'maintenance_bills.member_id')
                ->join('users', 'members.user_id', '=', 'users.id')
                ->where('members.society_id', $this->selected_society)
                ->where('maintenance_bills.billing_year', $this->selected_year)
                ->where('maintenance_bills.billing_month', $this->selected_month)
                ->select(
                    'members.room_number', // Assuming room_no is in members table
                    'users.name',
                    'maintenance_bills.amount',
                    'maintenance_bills.status'
                )
                ->get();
    
            // Prepare the data for export
            $exportData = $membersBills->map(function ($bill, $index) {
                return [
                    'Sr No' => $index + 1,
                    'Room No' => $bill->room_number,
                    'Name' => $bill->name,
                    'Bill Amount' => $bill->amount,
                    'Status' => $bill->status == 1 ? 'Paid' : 'Not Paid',
                ];
            });
    
            // Export the data to an Excel file using FastExcel
            return (new FastExcel($exportData))->download('members_bills.xlsx');
        } else {
            session()->flash('error', 'Please select society, year, and month before exporting.');
            return redirect()->back();
        }
    }

    public function updatedSelectedSociety()
    {
        $this->fetchMembers();
    }

    public function updatedSelectedYear()
    {
        $this->fetchMembers();
    }

    public function updatedSelectedMonth()
    {
        $this->fetchMembers();
    }

    public function fetchMembers()
    {
        if (
            $this->selected_society &&
            $this->selected_year &&
            $this->selected_month
        ) {
            $this->members = Member::join(
                "maintenance_bills",
                "members.id",
                "=",
                "maintenance_bills.member_id"
            )
                ->join("users", "members.user_id", "=", "users.id")
                ->where("members.society_id", $this->selected_society)
                ->where("maintenance_bills.billing_year", $this->selected_year)
                ->where(
                    "maintenance_bills.billing_month",
                    $this->selected_month
                )
                ->where(function ($query) {
                    $query
                        ->where("users.name", "like", "%{$this->search}%")
                        ->orWhere("users.phone", "like", "%{$this->search}%")
                        ->orWhere("users.email", "like", "%{$this->search}%");
                })
                ->select(
                    "members.id as member_id",
                    "members.society_id",
                    "members.user_id",
                    "users.name",
                    "users.phone",
                    "users.email",
                    "maintenance_bills.id as bill_id",
                    "maintenance_bills.billing_month",
                    "maintenance_bills.amount",
                    "maintenance_bills.advance",
                    "maintenance_bills.status",
                    "members.created_at"
                )
                ->latest("members.created_at")
                ->get();
        } else {
            $this->members = collect();
        }
    }

    public function download($billId)
    {
        try {
            // Find the specific bill
            $bill = MaintenanceBill::findOrFail($billId);

            // Find the associated member
            $member = Member::with(["user", "society"])->findOrFail(
                $bill->member_id
            );

            // Get the current payment for this bill
            $currentPayment = Payment::where(
                "maintenance_bills_id",
                $bill->id
            )->first();

            // // Service Charges
            // $servicesCharges = $member->society->service_charges;

            // // Parking charges
            // $parkingCharges = $member->society->parking_charges;

            // maintenance amount
            $maintenanceAmount = $member->is_rented
                ? $member->society->maintenance_amount_rented
                : $member->society->maintenance_amount_owner;

            // late fee
            $lateFee = 0;
            if ($bill->late_fee_applied) {
                $lateFee = $member->society->late_fee;
            }

            // Get the most recent previous payment for this member
            $previousPayment = Payment::where(
                "maintenance_bills_id",
                "<>",
                $bill->id
            )
                ->whereHas("maintenanceBill", function ($query) use ($bill) {
                    $query->where("member_id", $bill->member_id);
                })
                ->latest("payment_date")
                ->first();
            $amountInWords = AmountHelper::amountToWords(
                $currentPayment ? $currentPayment->amount_paid : $bill->amount
            );

            $data = [
                "member" => $member,
                "bill" => $bill,
                "society" => $member->society,
                "currentPayment" => $currentPayment,
                "previousPayment" => $previousPayment,
                "amountInWords" => $amountInWords,
                "payment_mode_id" => $bill->payment_mode_id,
                "reference_no" => $currentPayment
                    ? $currentPayment->reference_no
                    : null,
                "transaction_id" => $currentPayment
                    ? $currentPayment->transaction_id
                    : null,
                "maintenance_amount" => $maintenanceAmount,
                "late_fee" => $lateFee,
                // 'service_charges' => $servicesCharges,
                // 'parking_charges' => $parkingCharges,
            ];

            if ($bill->status == 1) {
                $pdf = Pdf::loadView("pdfs.receipt", $data);
                $filename = "receipt_{$bill->id}.pdf";
            } elseif ($bill->status == 0) {
                $pdf = Pdf::loadView("pdfs.invoice", $data);
                $filename = "invoice_{$bill->id}.pdf";
            } else {
                return response()->json(
                    ["error" => "Invalid bill status"],
                    400
                );
            }

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->stream();
            }, $filename);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(
                ["error" => "Bill or Member not found"],
                404
            );
        } catch (\Exception $e) {
            return response()->json(
                ["error" => "An error occurred while processing your request"],
                500
            );
        }
    }

    public function applyLateFees()
    {
        $today = now();
        $overdueBills = MaintenanceBill::where("status", 0)
            ->where("due_date", "<", $today->subDays(15))
            ->get();

        foreach ($overdueBills as $bill) {
            $society = Societies::find($bill->member->society_id);
            $lateFee = $society->late_fee;

            $bill->amount += $lateFee;
            $bill->late_fee_applied = true;
            $bill->save();
        }

        session()->flash("success", "Late fees applied successfully!");
    }

    public function downloadSelected()
    {
        try {
            \Log::info("downloadSelected method called");
            \Log::info(
                "Selected members: " . json_encode($this->selectedMembers)
            );

            if (empty($this->selectedMembers)) {
                return response()->json(
                    ["error" => "No members selected"],
                    400
                );
            }

            $members = Member::with(["user", "society"])
                ->whereIn("id", $this->selectedMembers)
                ->get();

            // Check if members exist
            if ($members->isEmpty()) {
                return response()->json(["error" => "No members found"], 404);
            }

            // Get the society from the first member (assuming all selected members belong to the same society)
            $society = $members->first()->society;

            if (!$society) {
                return response()->json(["error" => "Society not found"], 404);
            }

            // Fetch bills for the selected members
            $bills = MaintenanceBill::whereIn(
                "member_id",
                $this->selectedMembers
            )->get();

            $pdfData = [];

            foreach ($members as $member) {
                $bill = $bills->where("member_id", $member->id)->first();
                if (!$bill) {
                    continue;
                }

                $currentPayment = Payment::where(
                    "maintenance_bills_id",
                    $bill->id
                )->first();

                $maintenanceAmount = $member->is_rented
                    ? $society->maintenance_amount_rented
                    : $society->maintenance_amount_owner;

                $lateFee = 0;
                if ($bill->late_fee_applied) {
                    $lateFee = $society->late_fee;
                }

                $previousPayment = Payment::where(
                    "maintenance_bills_id",
                    "<>",
                    $bill->id
                )
                    ->whereHas("maintenanceBill", function ($query) use (
                        $member
                    ) {
                        $query->where("member_id", $member->id);
                    })
                    ->latest("payment_date")
                    ->first();

                $amountInWords = AmountHelper::amountToWords(
                    $currentPayment
                        ? $currentPayment->amount_paid
                        : $bill->amount
                );

                $pdfData[] = [
                    "member" => $member,
                    "bill" => $bill,
                    "society" => $society,
                    "currentPayment" => $currentPayment,
                    "previousPayment" => $previousPayment,
                    "amountInWords" => $amountInWords,
                    "payment_mode_id" => $bill->payment_mode_id,
                    "reference_no" => $currentPayment
                        ? $currentPayment->reference_no
                        : null,
                    "transaction_id" => $currentPayment
                        ? $currentPayment->transaction_id
                        : null,
                    "maintenance_amount" => $maintenanceAmount,
                    "late_fee" => $lateFee,
                    "type" => $bill->status == 0 ? "invoice" : "receipt",
                ];
            }

            if (empty($pdfData)) {
                return response()->json(
                    ["error" => "No valid bills found for selected members"],
                    404
                );
            }

            // Generate PDF
            $pdf = PDF::loadView("pdfs.combined", ["data" => $pdfData]);

            return $pdf->download("combined_bills.pdf");
        } catch (\Exception $e) {
            \Log::error("Error in downloadSelected: " . $e->getMessage());
            return response()->json(
                ["error" => "An error occurred while processing your request"],
                500
            );
        }
    }

    private function amountToWords($amount)
    {
        $ones = [
            1 => "one",
            2 => "two",
            3 => "three",
            4 => "four",
            5 => "five",
            6 => "six",
            7 => "seven",
            8 => "eight",
            9 => "nine",
            10 => "ten",
            11 => "eleven",
            12 => "twelve",
            13 => "thirteen",
            14 => "fourteen",
            15 => "fifteen",
            16 => "sixteen",
            17 => "seventeen",
            18 => "eighteen",
            19 => "nineteen",
        ];
        $tens = [
            2 => "twenty",
            3 => "thirty",
            4 => "forty",
            5 => "fifty",
            6 => "sixty",
            7 => "seventy",
            8 => "eighty",
            9 => "ninety",
        ];
        $scales = [
            "",
            "thousand",
            "million",
            "billion",
            "trillion",
            "quadrillion",
            "quintillion",
        ];

        if ($amount == 0) {
            return "zero";
        }

        $amount = number_format($amount, 2, ".", "");
        $numberWords = [];
        $wholeNumber = floor($amount);
        $decimal = round(($amount - $wholeNumber) * 100);

        $groups = str_split(strrev(strval($wholeNumber)), 3);

        for ($i = 0; $i < count($groups); $i++) {
            $number = strrev($groups[$i]);
            if ($number != "000") {
                $groupWords = [];
                if ($number > 99) {
                    $groupWords[] = $ones[substr($number, 0, 1)] . " hundred";
                    $number = substr($number, 1);
                }
                if ($number > 19) {
                    $groupWords[] = $tens[substr($number, 0, 1)];
                    $number = substr($number, 1);
                }
                if ($number > 0) {
                    $groupWords[] = $ones[$number];
                }
                $numberWords[] =
                    implode(" ", $groupWords) .
                    ($i > 0 ? " " . $scales[$i] : "");
            }
        }

        $wholeWords = implode(" ", array_reverse($numberWords));

        if ($decimal > 0) {
            return $wholeWords . " and " . $decimal . "/100";
        }

        return $wholeWords;
    }

    /*  public function sendWhatsAppMessage($memberId)
     {
         // Fetch the latest member information and their latest bill
         $member = Member::with('user')->find($memberId);
         if (!$member) {
             return;
         }

         // Ensure that the latest bill is fetched
         $bill = MaintenanceBill::where('member_id', $memberId)
             ->latest('due_date')
             ->first();
         if (!$bill) {
             return;
         }

         $previousPayment = Payment::where('maintenance_bills_id', '<>', $bill->id)
             ->whereHas('maintenanceBill', function ($query) use ($bill) {
                 $query->where('member_id', $bill->member_id);
             })
             ->latest('payment_date')
             ->first();

         $maintenanceAmount = $member->is_rented ? $member->society->maintenance_amount_rented : $member->society->maintenance_amount_owner;

         $lateFee = 0;
         if ($bill->late_fee_applied) {
             $lateFee = $member->society->late_fee;
         }

         // Convert billing month number to month name
         $billingMonth = DateTime::createFromFormat('!m', $bill->billing_month)->format('F');

         // Adjust the message to use the month name
         $message = $bill->status
             ? "Dear {$member->user->name}, your maintenance bill for the period {$billingMonth} {$bill->billing_year} is paid. Your invoice number is {$bill->id}. Thank you!"
             : "Dear {$member->user->name}, your maintenance bill for the period {$billingMonth} {$bill->billing_year} is pending. Please pay by {$bill->due_date}. Your invoice number is {$bill->id}.";

         // Send the WhatsApp message
         $this->sendWhatsApp($member->user->phone, $message);

         // Dispatch an event to indicate that the message was sent
         $this->dispatch('whatsappMessageSent');
     } */

    public function sendWhatsAppMessage($billId)
    {
        try {
            $bill = MaintenanceBill::findOrFail($billId);
            $member = Member::with(["user", "society"])->findOrFail(
                $bill->member_id
            );
            if ($bill->status == 1) {
                $message = "Dear {$member->user->name}, your bill for {$bill->billing_month} has been successfully paid. Thank you!";
            } else {
                $message = "Dear {$member->user->name}, your bill for {$bill->billing_month} is still pending. Please make the payment at your earliest convenience.";
            }
            $this->sendWhatsApp($member->user->phone, $message);
            session()->flash("message", "WhatsApp message sent successfully.");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            session()->flash("error", "Bill or Member not found.");
        } catch (\Exception $e) {
            session()->flash(
                "error",
                "An error occurred while sending the message."
            );
        }
    }

    protected function sendWhatsApp($phone, $message)
    {
        // config form env
        $sid = config("services.twilio.sid");
        $token = config("services.twilio.token");
        $from = config("services.twilio.whatsapp_from");
        $to = "whatsapp:" . $phone; //recevier number

        $client = new Client($sid, $token);
        $client->messages->create($to, [
            "from" => $from, // from config our virtual number
            "body" => $message,
        ]);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    private function calculateDueDate($societyDueDate, $billingMonth, $billingYear)
    {
        $dueDate = Carbon::createFromDate($billingYear, $billingMonth, $societyDueDate);

        // if ($dueDate->isPast()) {
        //     $dueDate->addMonth();
        // }

        return $dueDate;
    }

    public function generateBills()
    {
        try {
            // Check if month and year are selected
            if (empty($this->selected_month) || empty($this->selected_year)) {
                throw new \Exception("Please select both month and year.");
            }

            $society = Societies::findOrFail($this->selected_society);

            if (!$society->due_date) {
                throw new \Exception("Due date is not set for this society.");
            }

            $members = Member::where(
                "society_id",
                $this->selected_society
            )->get();
            $newBillsCount = 0;

            foreach ($members as $member) {
                $existingBill = MaintenanceBill::where("member_id", $member->id)
                    ->where("billing_month", $this->selected_month)
                    ->where("billing_year", $this->selected_year)
                    ->first();

                if (!$existingBill) {
                    $parkingCharges = $society->parking_charges;
                    $servicesCharges = $society->service_charges;
                    $maintenanceAmount = $member->is_rented
                        ? $society->maintenance_amount_rented
                        : $society->maintenance_amount_owner;

                    $amount =
                        $parkingCharges + $servicesCharges + $maintenanceAmount;

                    $dueDate = $this->calculateDueDate(
                        $society->due_date,
                        $this->selected_month,
                        $this->selected_year
                    );

                    MaintenanceBill::create([
                        "member_id" => $member->id,
                        "amount" => $amount,
                        "status" => 0,
                        "due_date" => $dueDate,
                        "billing_month" => $this->selected_month,
                        "billing_year" => $this->selected_year,
                    ]);

                    $newBillsCount++;
                }
            }

            if ($newBillsCount > 0) {
                session()->flash(
                    "success",
                    "$newBillsCount bills generated successfully!"
                );
            } else {
                session()->flash("info", "No new bills were generated.");
            }

            $this->fetchMembers(); // Refresh the members list
        } catch (\Exception $ex) {
            session()->flash(
                "error",
                "Error generating bills: " . $ex->getMessage()
            );
        }
    }

    public function updatedSelectedMembers()
    {
        $this->selectAll =
            count($this->selectedMembers) === $this->members->count();
        \Log::info(
            "Updated Selected Members: " . json_encode($this->selectedMembers)
        );
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedMembers = $this->members
                ->pluck("id")
                ->map(fn($id) => (string) $id)
                ->toArray();
        } else {
            $this->selectedMembers = [];
        }
    }

    public function render()
    {
        $this->fetchMembers();
        \Log::info("Rendering. Members count: " . $this->members->count());
        \Log::info(
            "Rendering. Selected Members: " .
                json_encode($this->selectedMembers)
        );

        $bills = MaintenanceBill::with("member.user")->get();
        return view("livewire.maintenance-bill.maintenance-bill-index", [
            "months" => $this->months,
            "members" => $this->members,
            "members" => Member::all(),
            "bills" => $bills,
            "currentSociety" => $this->society,
        ])->layout("layouts.app", ["society" => $this->society]);
    }
}
