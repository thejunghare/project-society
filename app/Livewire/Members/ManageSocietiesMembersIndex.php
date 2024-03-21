<?php

namespace App\Livewire\Members;

use App\Models\Member;
use Livewire\Component;
use App\Models\Societies;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ManageSocietiesMembersIndex extends Component
{
    use WithPagination;

    public $societies;
    public $selectedSociety;
    public $search;

    public $currentYear, $customer, $invoice, $item, $bill;

    public function mount()
    {
        $this->societies = Societies::where('accountant_id', Auth::user()->id)->pluck('name', 'id');

        $this->currentYear = date('Y');
    }

    public function generatePdf($invoiceId, $memberId)
    {
        /* $invoice = Member::with(['user', 'society', 'bill']) // Eager load the bill relationship
            ->where('id', $memberId)
            ->first();

        $billDetails = $invoice->bill->where('id', $invoiceId)->first();

        return Pdf::view('pdf.invoice', ['invoice' => $invoice])
            ->save(storage_path('app/files/maintenance_bill.pdf')); */
    }

    public function download()
    {
        // dd(123);
        $data = [
            "title" => "hello",
            "description" => "test test test"
        ];

        $pdf = Pdf::loadView('pdfs.preview', $data);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream(); // Echo download contents directly...
        }, 'invoice.pdf');
    }

    public function render()
    {
        $members = $this->selectedSociety
            ? Member::join('bills', 'members.id', '=', 'bills.member_id')
                ->join('users', 'members.user_id', '=', 'users.id')
                ->where('members.society_id', $this->selectedSociety)
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
                    'bills.id as bill_id',
                    'bills.billing_month',
                    'bills.amount',
                    'bills.status',
                    'members.created_at'
                )
                ->latest('members.created_at')
                ->paginate(5)
            : collect();

        return view('livewire.members.manage-societies-members-index', [
            'members' => $members,
        ])->title('Manage society members - societies');
    }
}
