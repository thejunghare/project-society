<?php

namespace App\Livewire\MaintenanceBill;

use DateTime;
use App\Models\Member;
use App\Models\Societies;
use Livewire\Component;
use Twilio\Rest\Client;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Models\MaintenanceBill;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaintenanceBillIndex extends Component
{
    use WithPagination;

    #[Title('Maintenance Bill - mySocietyERP')]
    public $society;
    public $societiesList, $months, $search, $selected_society, $selected_year, $selected_month, $members;
    public $selectedMembers = [];
    public $selectAll = false;
    public $amount, $due_date;

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedMembers = $this->members->pluck('id')->toArray();
        } else {
            $this->selectedMembers = [];
        }
    }

    public function mount(Societies $society)
    {
        $this->society = $society;
        $this->societiesList = Societies::where('accountant_id', Auth::user()->id)->pluck('name', 'id');
        $this->months = $this->returnMonths();
        $this->members = collect();
        $this->selected_society = $society->id;
    }

    public function goBack()
    {
        return redirect('/accountant/manage/societies/' . $this->society->id . '/society-details');
    }


    public function returnMonths()
    {
        return [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];
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

    // TODO -> implement pagination here
    public function fetchMembers()
    {
        if ($this->selected_society && $this->selected_year && $this->selected_month) {
            $this->members = Member::join('maintenance_bills', 'members.id', '=', 'maintenance_bills.member_id')
                ->join('users', 'members.user_id', '=', 'users.id')
                ->where('members.society_id', $this->selected_society)
                ->where('maintenance_bills.billing_year', $this->selected_year)
                ->where('maintenance_bills.billing_month', $this->selected_month)
                ->where(function ($query) {
                    $query->where('users.name', 'like', "%{$this->search}%")
                        ->orWhere('users.phone', 'like', "%{$this->search}%")
                        ->orWhere('users.email', 'like', "%{$this->search}%");
                })
                ->select(
                    'members.id as member_id',
                    'members.society_id',
                    'members.user_id',
                    'users.name',
                    'users.phone',
                    'users.email',
                    'maintenance_bills.id as bill_id',
                    'maintenance_bills.billing_month',
                    'maintenance_bills.amount',
                    'maintenance_bills.advance',
                    'maintenance_bills.status',
                    'members.created_at'
                )
                ->latest('members.created_at')
                ->get();
        } else {
            $this->members = collect();
        }
    }

    public function download($memberId)
    {
        $member = Member::with('user')->findOrFail($memberId);

        $bill = MaintenanceBill::where('member_id', $memberId)->firstOrFail();

        $society = Societies::where('id', $member->society_id)->firstOrFail();

        $data = [
            'member' => $member,
            'bill' => $bill,
            'society' => $society,
        ];

        $pdf = Pdf::loadView('pdfs.invoice', $data);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'invoice.pdf');
    }

    public function downloadSelected()
    {
        if (empty($this->selectedMembers)) {
            return;
        }

        $members = Member::with('user')->whereIn('id', $this->selectedMembers)->get();

        if ($members->isEmpty()) {
            return;
        }

        $society = Societies::find($members->first()->society_id);

        if (!$society) {
            return;
        }

        $bills = MaintenanceBill::whereIn('member_id', $this->selectedMembers)->get();

        $data = [
            'members' => $members,
            'bills' => $bills,
            'society' => $society,
        ];

        $pdf = Pdf::loadView('pdfs.invoices', $data);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'invoices.pdf');
    }

    public function sendWhatsAppMessage($memberId)
    {
        $member = Member::with('user')->find($memberId);
        if (!$member) {
            return;
        }

        $bill = MaintenanceBill::where('member_id', $memberId)->first();
        if (!$bill) {
            return;
        }

        // Convert billing month number to month name
        $billingMonth = DateTime::createFromFormat('!m', $bill->billing_month)->format('F');

        // Adjust the message to use the month name
        $message = $bill->status
            ? "Dear {$member->user->name}, your maintenance bill for the period {$billingMonth} {$bill->billing_year} is paid. Your invoice number is {$bill->id}. Thank you!"
            : "Dear {$member->user->name}, your maintenance bill for the period {$billingMonth} {$bill->billing_year} is pending. Please pay by {$bill->due_date}. Your invoice number is {$bill->id}.";


        // Sending the WhatsApp message
        $this->sendWhatsApp($member->user->phone, $message);

        // Generate and attach the invoice PDF
        $data = [
            'member' => $member,
            'bill' => $bill,
            'society' => Societies::find($member->society_id),
        ];

        $pdf = Pdf::loadView('pdfs.invoice', $data);
        $filePath = storage_path('app/public/invoice-' . $bill->id . '.pdf');
        $pdf->save($filePath);

        // Send the PDF as an attachment
        $this->sendWhatsAppWithMedia($member->user->phone, $message, $filePath);

        // Dispatch an event to indicate that the message was sent
        $this->dispatch('whatsappMessageSent');
    }

    protected function sendWhatsApp($phone, $message)
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from = config('services.twilio.whatsapp_from');
        $to = 'whatsapp:' . $phone;

        $client = new Client($sid, $token);
        $client->messages->create($to, [
            'from' => $from,
            'body' => $message,
        ]);
    }

    protected function sendWhatsAppWithMedia($phone, $message, $filePath)
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from = config('services.twilio.whatsapp_from');
        $to = 'whatsapp:' . $phone;

        $client = new Client($sid, $token);
        $client->messages->create($to, [
            'from' => $from,
            'body' => $message,
            'mediaUrl' => [url('storage/invoice-' . basename($filePath))],
        ]);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }


    // ... other properties
    public function generateBills()
    {

     //   dd('generateBills called', $this->members,  $this->due_date, $this->selected_month, $this->selected_year);

        $this->validate([
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
        ]); 

       // dd('generateBills called', $this->members,  $this->due_date, $this->selected_month, $this->selected_year);
        $members = Member::All();
        try {
            foreach ($members as $member) {
                $society = Societies::find($member->society_id);
                $parkingCharges = $society->parking_charges;
                $servicesCharges = $society->services_charges;
               $maintenance_due_date = $society->maintenance_due_date;
                $maintenanceAmount = $member->isRented
                    ? $society->maintenance_amount_rented
                    : $society->maintenance_amount_owner;

                $amount = $parkingCharges + $servicesCharges + $maintenanceAmount;
                //dd('Amount:', $amount, 'Society ID:', $society->id);

                MaintenanceBill::create([
                    'member_id' => $member->id,
                    'amount' => $amount,
                    'status' => 0,
                    'due_date' => $maintenance_due_date,
                    'billing_month' => $this->selected_month,
                    'billing_year' => $this->selected_year,
                ]);
            }
            session()->flash('success', 'Post Created Successfully!!');

        } catch (\Exception $ex) {
            session()->flash('error', 'Something goes wrong!!');
        }


        $this->fetchMembers();

        // for temp uses only
        // TODO -> fix redirect
        return redirect()->to('accountant/manage/societies/1/society-details/bills/maintenance-bill');
    }


    public function render()
    {
        return view('livewire.maintenance-bill.maintenance-bill-index', [
            'months' => $this->months,
            'members' => $this->members,
            'currentSociety' => $this->society,
        ]);
    }
}
