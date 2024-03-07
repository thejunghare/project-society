<?php

namespace App\Livewire\Members;

use App\Models\Member;
use Livewire\Component;
use App\Models\Societies;
use Livewire\WithPagination;
use Spatie\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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

    public function generatePdf( $invoice)
    {
        $invoice = Member::with(['user', 'society', 'bills.payments'])->find($invoice);

        $userName = $invoice->user->name;
        $societyName = $invoice->society->name;
        $bills = $invoice->bills; //

        return Pdf::view('pdfs.invoice', ['invoice' => $invoice])
            ->save(storage_path('app/files/invoice.pdf'));
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
