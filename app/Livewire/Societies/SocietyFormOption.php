<?php

namespace App\Livewire\Societies;

use App\Models\Member;
use Livewire\Component;
use App\Models\Societies;
use Illuminate\Support\Facades\Auth;

class SocietyFormOption extends Component
{
    public $societyId;
    public $societyName;
    public $room_number;
    public $is_rented;
    public $selectedSociety;

    protected $rules = [
        'room_number' => 'required',
        'is_rented' => 'required|boolean',
        'selectedSociety' => 'required',
    ];

    public function save()
{
    $this->validate();

    try {
        $member = new Member();
        $member->society_id = $this->selectedSociety;
        $member->user_id = Auth::user()->id;
        $member->room_number = $this->room_number;
        $member->is_rented = $this->is_rented;
        $member->save();

        $this->reset('room_number', 'is_rented', 'selectedSociety');

        session()->flash('success', 'You are now a member.');
        return redirect('/dashboard');
    } catch (\Exception $e) {
        session()->flash('error', 'An error occurred while saving: ' . $e->getMessage());
    }
}

    public function mount()
    {
        $this->societyName = Societies::pluck('name', 'id');
    }

    public function render()
    {
        return view('livewire.societies.society-form-option');
    }
}
