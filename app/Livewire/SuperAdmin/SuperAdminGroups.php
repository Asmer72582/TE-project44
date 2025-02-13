<?php

namespace App\Livewire\SuperAdmin;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SuperAdminGroups extends Component
{

    public $groups;
    public $group_no;
    public $count = 1;

    public function mount($group_no)
    {

        $this->group_no = $group_no;

        if ($group_no == null) {
            $this->groups = User::where('user_type', 'instructor')->get();
        } else {
            $this->groups = User::where('group_no', $group_no)->orderby("user_type", "ASC")->get();
        }

    }

    public function render()
    {
        return view('livewire.super-admin.super-admin-groups');
    }
}
