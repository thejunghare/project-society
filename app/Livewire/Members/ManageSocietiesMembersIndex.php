<?php

namespace App\Livewire\Members;

use App\Models\Member;
use Livewire\Component;
use App\Models\Societies;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;

class ManageSocietiesMembersIndex extends Component
{
    use WithPagination;

    public $societies;
    public $selectedSociety;
    public $search;

    public function mount()
    {
        $this->societies = Societies::where('accountant_id', 1)->pluck('name', 'id');

    }

    public function render()
    {


        $members = $this->selectedSociety
            ? Member::where('society_id', $this->selectedSociety)
                ->join('users', 'members.user_id', '=', 'users.id')
                ->where(function ($query) {
                    $query->where('users.name', 'like', "%{$this->search}%")
                        ->orWhere('users.phone', 'like', "%{$this->search}%")
                        ->orWhere('users.email', 'like', "%{$this->search}%");
                })
                ->select('users.name', 'users.phone', 'users.email')
                ->latest('members.created_at')
                ->paginate(5)
            : collect();



        return view('livewire.members.manage-societies-members-index', [
            'members' => $members,
        ])->title('Manage society members - societies');
    }
}
