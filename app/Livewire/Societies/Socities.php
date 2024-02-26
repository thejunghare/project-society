<?php

namespace App\Livewire\Societies;

use App\Models\Societies;
use Livewire\Component;

class Socities extends Component
{

    public $socities, $name, $phone, $address, $bank_name, $bank_ifsc_code, $bank_account_number, $member_count, $accountant_id, $president_name, $vice_president_name, $treasurer_name, $secretary_name;

    public function render()
    {
        $this->socities = Societies::latest()->get();
        return view('livewire.societies.socities');
    }
}
