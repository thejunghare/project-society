<?php

namespace App\Livewire\Members;

use Livewire\Component;
use App\Models\Societies;
use Livewire\Attributes\Title;

class ManageSocietiesMembersIndex extends Component
{
    #[Title('Manage members - mySocietyERP')]
    public $societyId;
    public $society;
    // public $members;

    public function mount($society)
    {
        $this->societyId = $society;
        $this->loadSocietyMembers($this->societyId);
    }

    public function loadSocietyMembers($societyId)
    {
        $this->society = Societies::with('members')->findOrFail($societyId);
    }

    public function render()
    {
        $this->members = $this->society->members()->paginate(5);

        return view('livewire.members.manage-societies-members-index', [
            'society' => $this->society,
            'members' => $this->members,
        ]);
    }
}
