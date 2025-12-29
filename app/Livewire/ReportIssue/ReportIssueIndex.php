<?php

namespace App\Livewire\ReportIssue;

use App\Models\Issue;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ReportIssueIndex extends Component
{
    #[Validate('required')]
    public $description;

    public function save()
    {
        $this->validate();

        Issue::create([
            'user_id' => Auth::id(),
            'description' => $this->description,
        ]);

        session()->flash('success', 'Your issue was reported, our team will contact you!');

        return redirect()->route('report');
    }

    public function render()
    {
        return view('livewire.report-issue.report-issue-index');
    }
}
