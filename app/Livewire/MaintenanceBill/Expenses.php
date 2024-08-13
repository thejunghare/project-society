<?php

namespace App\Livewire\MaintenanceBill;

use Livewire\Component;
use App\Models\Societies;
use App\Models\Member;
use App\Models\MaintenanceBill;
use App\Models\expense;
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


    public function submitExpense()
    {
        $this->validate([
            'amount' => 'required|numeric|min:0',
            'selectedExpenseType' => 'required|exists:expense_types,id',
            'remark' => 'nullable|string|max:255',
        ]);
    
        // Create a new expense record
        $expense = new Expense();
        $expense->society_id = $this->selected_society;
        $expense->price = $this->amount;
        $expense->expense_type_id = $this->selectedExpenseType;
        $expense->remark = $this->remark;
        $expense->save();
    
        // Reset form fields
        $this->reset(['price', 'selectedExpenseType', 'remark']);
    
        // Show a success message
        session()->flash('message', 'Expense added successfully.');
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
        $this->fetchMembers();
        \Log::info("Rendering. Members count: " . $this->members->count());
        \Log::info(
            "Rendering. Selected Members: " .
                json_encode($this->selectedMembers)
        );

        $bills = MaintenanceBill::with("member.user")->get();
        return view("livewire.maintenance-bill.expenses", [
            "months" => $this->months,
            "members" => $this->members,
            "members" => Member::all(),
            "bills" => $bills,
            "currentSociety" => $this->society,
        ])->layout("layouts.app", ["society" => $this->society]);
    }
}
