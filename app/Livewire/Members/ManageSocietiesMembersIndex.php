<?php

namespace App\Livewire\Members;

use App\Models\Member;
use Livewire\Component;
use App\Models\Societies;
use Livewire\WithPagination;
use LaravelDaily\Invoices\Invoice;
use Spatie\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class ManageSocietiesMembersIndex extends Component
{
    use WithPagination;

    public $societies;
    public $selectedSociety;
    public $search;
    public $months;
    public $currentYear, $customer, $invoice, $item;

    public function mount()
    {
        $this->societies = Societies::where('accountant_id', Auth::user()->id)->pluck('name', 'id');
        $this->months = [
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
            "December"
        ];
        $this->currentYear = date('Y');
    }

    public function generatePdf(Invoice $invoice)
    {
        $members = $this->selectedSociety
            ? Member::where('society_id', $this->selectedSociety)
                ->join('bills', 'members.id', '=', 'bills.member_id')
                ->join('users', 'members.user_id', '=', 'users.id')
                ->where(function ($query) {
                    $query->where('users.name', 'like', "%{$this->search}%")
                        ->orWhere('users.phone', 'like', "%{$this->search}%")
                        ->orWhere('users.email', 'like', "%{$this->search}%");
                })
                ->select('users.name', 'users.phone', 'users.email', 'bills.id', 'bills.billing_month', 'bills.amount', 'bills.status')
                ->latest('members.created_at')
                ->paginate(5)
            : collect();

        return Pdf::view('pdfs.invoice', ['members' => $members])
            ->save(storage_path('app/files/invoice.pdf'));
    }

    public function render()
    {
        $members = $this->selectedSociety
            ? Member::where('society_id', $this->selectedSociety)
                ->join('bills', 'members.id', '=', 'bills.member_id')
                ->join('users', 'members.user_id', '=', 'users.id')
                ->where(function ($query) {
                    $query->where('users.name', 'like', "%{$this->search}%")
                        ->orWhere('users.phone', 'like', "%{$this->search}%")
                        ->orWhere('users.email', 'like', "%{$this->search}%");
                })
                ->select('users.name', 'users.phone', 'users.email', 'bills.id', 'bills.billing_month', 'bills.amount', 'bills.status')
                ->latest('members.created_at')
                ->paginate(5)
            : collect();

        return view('livewire.members.manage-societies-members-index', [
            'members' => $members,
        ])->title('Manage society members - societies');
    }
}
