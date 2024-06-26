<?php

namespace App\Livewire\Members;

use Livewire\Component;
use App\Models\Societies;
use App\Models\Member;
use App\Models\User;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Redirect;

class ManageSocietiesMembersIndex extends Component
{
  #[Title('Manage members - mySocietyERP')]
  public $societyId;
  public $society;
  public $member_count;
  public $editingMember = null;
  public $name, $phone, $room_number, $is_rented;

  public function memberCout()
  {
    return $this->society->members()->count();
  }



  public function mount($society)
  {
    $this->societyId = $society;
    $this->loadSocietyMembers($this->societyId);
  }

  public function loadSocietyMembers($societyId)
  {
    $this->society = Societies::with('members')->findOrFail($societyId);
  }

  public function RegisteredMembers($id)
  {
    $society = Societies::findOrFail($id);
    return $society->members()->count();
  }

  public function TotalMembers($society_id)
  {
    $society = Societies::findOrFail($society_id);
    return $this->member_count = $society->member_count;
  }

  public function startEdit($memberId)
  {
    $member = Member::with('user')->findOrFail($memberId);
    $this->editingMember = $member->id;
    $this->name = $member->user->name;
    $this->phone = $member->user->phone;
    $this->room_number = $member->room_number;
    $this->is_rented = $member->is_rented ? '1' : '0'; // Convert boolean to string '0' or '1'
  }

  public function updateMember($memberId)
  {
    $member = Member::findOrFail($memberId);
    $member->user->name = $this->name;
    $member->user->phone = $this->phone;
    $member->room_number = $this->room_number;
    $member->is_rented = $this->is_rented == '1'; // Convert string '1' or '0' to boolean
    $member->user->save();
    $member->save();

    $this->editingMember = null;
  }

  public function cancelEdit()
  {
    $this->editingMember = null;
  }

  public function save()
  {
    $member = Member::findOrFail($this->editingMember);
    $member->room_number = $this->room_number;
    $member->is_rented = $this->is_rented == '1'; // Convert string '1' or '0' to boolean
    $member->save();

    $user = User::findOrFail($member->user_id);
    $user->name = $this->name;
    $user->phone = $this->phone;
    $user->save();

    $this->editingMember = null;

    return redirect('/accountant/manage/societies/' . $this->societyId . '/society-details/members')->with([
      'success' => 'Members Details Updated successfully'
    ]);
    //   return redirect('/accountant/manage/societies/')->with([
    //     'success' => 'Members Details Updated successfully'
    // ]);
  }

  public function deleteMember($memberId)
  {
    // Delete related maintenance bills
    \DB::table('maintenance_bills')->where('member_id', $memberId)->delete();

    // Delete the member
    Member::findOrFail($memberId)->delete();

    // Refresh the member list
    $this->loadSocietyMembers($this->societyId);
      return redirect('/accountant/manage/societies/' . $this->societyId . '/society-details/members')->with([
        'success' => 'Members Deleted successfully'
    ]);
    // $this->loadSocietyMembers($this->societyId);
    // return redirect('/accountant/manage/societies/')->with([
    //   'success' => 'Members Deleted successfully'
    // ]);
  }

  public function goBack()
  {
    return redirect('/accountant/manage/societies/' . $this->societyId . '/society-details');
  }

  public function render()
  {
    $this->members = $this->society->members()->paginate(5);

    return view('livewire.members.manage-societies-members-index', [
      'society' => $this->society,
      'members' => $this->members,
      'registeredMembers' => $this->RegisteredMembers($this->societyId),
      'totalMembers' => $this->TotalMembers($this->societyId),
    ]);
  }
}
