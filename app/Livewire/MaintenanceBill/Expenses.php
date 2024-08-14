<?php

namespace App\Livewire\MaintenanceBill;

use Livewire\Component;
use App\Models\Societies;
use App\Models\Member;
use App\Models\MaintenanceBill;
use App\Models\expense;
use App\Models\ExpenseType;
use App\Models\User;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Redirect;
use DateTime;
use Carbon\Carbon;
use App\Livewire\DatePicker;
use Twilio\Rest\Client;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Helpers\AmountHelper;
use App\Models\Payment;
use ZipArchive;
use App\Models\Receipts;
use Barryvdh\DomPDF\Facade\Pdf;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Expenses extends Component
{
    public $societyId;
    public $society;
    public $months;
    public $search;
    public $selected_society;
    public $selected_year;
    public $selected_month;
    public $societiesList;
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
    public $expenseTypes;
    public $expenses;
    public $reference_number;

    public function mount(Societies $society)
    {
        $this->societyId = $society;
        $this->societiesList = Societies::where(
            "accountant_id",
            Auth::user()->id
        )->pluck("name", "id");
        $this->months = $this->returnMonths();
        $this->members = collect();
        $this->selected_society = $society->id;

        // Fetch expense types
        $this->expenseTypes = expense::all();
        $this->expenseTypes = ExpenseType::all();
    }

    public function loadExpenseTypes()
    {
        $this->expenseTypes = ExpenseType::all();
    }

    public $price;
    public $selectedExpenseType;
    public $remark;

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



    public function fetchExpenses()
    {
        if ($this->selected_year && $this->selected_month) {
            $monthNumber = $this->getMonthNumber($this->selected_month);

            if ($monthNumber === null) {
                // Handle invalid month
                return collect();
            }

            // Fetch expenses based on the selected bill month and year
            $expenses = Expense::where('society_id', $this->selected_society)
                ->where('bill_month', $monthNumber)
                ->where('bill_year', $this->selected_year)
                ->with('expenseType')
                ->get();

            // Optionally, map the expenses to include the expense type name
            $expenses = $expenses->map(function ($expense) {
                $expense->expense_type_name = $expense->expenseType->name;
                return $expense;
            });

            return $expenses;
        }

        return collect();
    }



    private function getMonthNumber($month)
    {
        if (is_numeric($month)) {
            // If the month is already a number, return it if it's valid
            $monthNum = intval($month);
            return ($monthNum >= 1 && $monthNum <= 12) ? $monthNum : null;
        }

        $datetime = DateTime::createFromFormat('F', $month);
        if ($datetime === false) {
            // Try with abbreviated month name
            $datetime = DateTime::createFromFormat('M', $month);
        }

        return ($datetime !== false) ? (int)$datetime->format('m') : null;
    }


    public function submitExpense()
    {
        // Check if both selected_month and selected_year are set
        if (!$this->selected_month || !$this->selected_year) {
            session()->flash('error', 'Please select both month and year.');
            return;
        }
    
        $this->validate([
            'selectedExpenseType' => 'required',
            'price' => 'required|numeric', // Ensure price is validated as numeric
            'remark' => 'nullable|string',
            'reference_number' => 'nullable|string',
        ]);
    
        // Retrieve the society record
        $society = Societies::find($this->selected_society);
    
        if (!$society) {
            session()->flash('error', 'Society not found.');
            return;
        }
    
        // Check if the society has enough balance
        if ($society->updated_balance < $this->price) {
            session()->flash('error', 'Insufficient balance.');
            return;
        }
    
        // Get the selected month and year
        $currentMonth = $this->selected_month; // e.g., 'August'
        $currentYear = $this->selected_year;   // e.g., 2024
    
        // Create the expense record
        Expense::create([
            'society_id' => $society->id,  // Assigning only the ID
            'expense_type_id' => $this->selectedExpenseType,
            'amount' => $this->price,
            'reference_number' => $this->reference_number,
            'remark' => $this->remark,
            'bill_month' => $currentMonth,  // Store the billing month
            'bill_year' => $currentYear,    // Store the billing year
        ]);
    
        // Subtract the amount from the society's updated_balance
        $society->updated_balance -= $this->price;
        $society->save(); // Save the updated society record
    
        // Flash success message
        session()->flash('message', 'Expense added successfully.');
    
        // Reset the form fields
        $this->reset(['selectedExpenseType', 'price', 'remark', 'reference_number', 'selected_month', 'selected_year']);
    }
    



    public function downloadBill($expenseId)
    {
        try {
            // Find the specific expense
            $expense = Expense::with('expenseType')->findOrFail($expenseId);

            // Fetch associated society (if needed)
            $society = $expense->society;

            // Create data array for the PDF
            $data = [
                'expense' => $expense,
                'society' => $society,
                'amountInWords' => $this->amountToWords($expense->amount), // Convert amount to words
            ];

            // Load the appropriate PDF view based on the expense details
            $pdf = PDF::loadView('pdfs.expense', $data);
            $filename = "expense_receipt_{$expense->id}.pdf";

            // Return the PDF file as a download
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->output();
            }, $filename);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Expense not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while processing your request'], 500);
        }
    }

    public function downloadExpenseExcel($expenseId)
    {
        try {
            // Find the specific expense
            $expense = Expense::with(['expenseType', 'societies'])->findOrFail($expenseId);

            // Prepare data for the Excel sheet
            $data = [
                [
                    'Expense ID' => $expense->id,
                    'Expense Type' => $expense->expenseType->name,
                    'Amount' => $expense->amount,
                    'Reference Number' => $expense->reference_number,
                    'Remark' => $expense->remark,
                    'Society' => $expense->society->name,
                    'Created At' => $expense->created_at->format('Y-m-d H:i:s'),
                    'Updated At' => $expense->updated_at->format('Y-m-d H:i:s'),
                    'Amount in Words' => $this->amountToWords($expense->amount),
                ]
            ];

            // Generate filename
            $filename = "expense_details_{$expense->id}.xlsx";

            // Create and return the Excel file as a download
            return (new FastExcel($data))->download($filename);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Expense not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while processing your request'], 500);
        }
    }



    public function updatedSelectedYear()
    {
        $this->fetchExpenses();
        $this->expenses = $this->fetchExpenses();
    }

    public function updatedSelectedMonth()
    {
        $this->fetchExpenses();
        $this->expenses = $this->fetchExpenses();
    }

    // public function fetchMembers()
    // {
    //     if (
    //         $this->selected_society &&
    //         $this->selected_year &&
    //         $this->selected_month
    //     ) {
    //         $this->members = Member::join(
    //             "maintenance_bills",
    //             "members.id",
    //             "=",
    //             "maintenance_bills.member_id"
    //         )
    //             ->join("users", "members.user_id", "=", "users.id")
    //             ->where("members.society_id", $this->selected_society)
    //             ->where("maintenance_bills.billing_year", $this->selected_year)
    //             ->where(
    //                 "maintenance_bills.billing_month",
    //                 $this->selected_month
    //             )
    //             ->where(function ($query) {
    //                 $query
    //                     ->where("users.name", "like", "%{$this->search}%")
    //                     ->orWhere("users.phone", "like", "%{$this->search}%")
    //                     ->orWhere("users.email", "like", "%{$this->search}%");
    //             })
    //             ->select(
    //                 "members.id as member_id",
    //                 "members.society_id",
    //                 "members.user_id",
    //                 "users.name",
    //                 "users.phone",
    //                 "users.email",
    //                 "maintenance_bills.id as bill_id",
    //                 "maintenance_bills.billing_month",
    //                 "maintenance_bills.amount",
    //                 "maintenance_bills.advance",
    //                 "maintenance_bills.status",
    //                 "members.created_at"
    //             )
    //             ->latest("members.created_at")
    //             ->get();
    //     } else {
    //         $this->members = collect();
    //     }
    // }





    public function member()
    {
        return $this->belongsTo(Member::class);
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


    public function goBack()
    {
        return $this->redirect(route('societyDetails', ['society' => $this->societyId]));
    }

    // public function mount($society)
    // {
    //     $this->societyId = $society;
    // }
    public function render()
    {
        // $this->fetchMembers();
        $this->expenses = $this->fetchExpenses();
        \Log::info("Expense Types: " . $this->expenseTypes->count());

        $bills = MaintenanceBill::with("member.user")->get();
        return view("livewire.maintenance-bill.expenses", [
            "months" => $this->months,
            "members" => $this->members,
            "bills" => $bills,
            "currentSociety" => $this->society,
            "expenses" => $this->expenses, // Add this line
            "expenseTypes" => $this->expenseTypes,
        ])->layout("layouts.app", ["society" => $this->society]);
    }
}
