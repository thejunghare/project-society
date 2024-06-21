<?php


namespace App\Livewire\Members;

use Livewire\Component;
use App\Models\Societies;
use App\Models\Member;
use App\Models\User;
use Livewire\Attributes\Title;

class ManageSocietiesMembersIndex extends Component
{
  #[Title('Manage members - mySocietyERP')]
  public $societyId;
  public $society;

  public $editingMember = null;
  public $name, $phone, $room_number, $is_rented;
/*   public $checkedMember = []; */

  public function mount($society)
  {
    $this->societyId = $society;
    $this->loadSocietyMembers($this->societyId);
  }

 /*  public function isChecked($memberId){
    return in_array($memberId, $this->checkedMember) ? 'bg-info text-white' : '';
}
 */
  public function loadSocietyMembers($societyId)
  {
    $this->society = Societies::with('members')->findOrFail($societyId);
  }

  public function startEdit($memberId)
  {
    $member = Member::with('user')->findorFail($memberId);
    $this->editingMember = $member->id;
    $this->name = $member->user->name;
    $this->phone = $member->user->phone;
    $this->room_number = $member->room_number;
    $this->is_rented = $member->is_rented;
  }

  public function cancelEdit()
  {
    $this->editingMember = null;
  }

  public function save($id)
  {
    $member = Member::findOrFail($this->editingMember);
    $member->room_number = $this->room_number;
    $member->is_rented = $this->is_rented;
    $member->save();

    $user = User::findOrFail($member->user_id);
    $user->name = $this->name;
    $user->phone = $this->phone;
    $user->save();

    $this->editingMember = null;
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

