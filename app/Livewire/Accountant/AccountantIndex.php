<?php

namespace App\Livewire\Accountant;

use App\Models\Member;
use App\Models\Societies;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Title;
   
class AccountantIndex extends Component
{
    #[Title('Accountant dashboard - Society')]
    public $registeredSocietiesCount;
    public $registeredSocietyMembersCount;
    public $presidentCount;
    public $vicePresidentCount;
    public $secretaryCount;
    public $treasurerCount;
    public $debugSocieties; // New debug property

    public function mount()
    {
        $societies = Societies::where('accountant_id', Auth::user()->id)->get();
        $this->registeredSocietiesCount = $societies->count();
        
        $societyIds = $societies->pluck('id')->toArray();
        $this->registeredSocietyMembersCount = Member::whereIn('society_id', $societyIds)->count();
        
        $this->presidentCount = $societies->whereNotNull('president_name')->count();
        $this->vicePresidentCount = $societies->whereNotNull('vice_president_name')->count();
        $this->secretaryCount = $societies->whereNotNull('secretary_name')->count();
        $this->treasurerCount = $societies->whereNotNull('treasurer_name')->count();

        // Debug information
        $this->debugSocieties = $societies->toArray();
    }

    public function render()
    {
        return view('livewire.accountant.accountant-index')
            ->title('Accountant dashboard - Society');
    }
}