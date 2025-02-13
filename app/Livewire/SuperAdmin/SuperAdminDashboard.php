<?php

namespace App\Livewire\SuperAdmin;

use App\Models\Notifications;
use App\Models\Proposals;
use App\Models\Repositories;
use App\Models\Tasks;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class SuperAdminDashboard extends Component
{

    public $participants_count = 0;
    public $notification_count = 0;

    // public $repositories_count = 0;
    public $tasks_count = 0;




    public function mount()
    {
        $this->participants_count = User::all()->groupBy("group_no")->count() - 1;
        $this->notification_count = Notifications::all()->count();
        // $this->repositories_count = Repositories::all()->count();
        $this->tasks_count = Tasks::where('group_no', 'system_group_dont_delete_row')->count();



    }

    public function render()
    {
        return view('livewire.super-admin.super-admin-dashboard');
    }
}
