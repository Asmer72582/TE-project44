<?php

namespace App\Livewire\Student;

use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StudentNotifications extends Component
{

    public $notifications;

    public function fetchNotifications(){
        $this->notifications = Notifications::where("group_no",Auth::user()->group_no)->orderBy("created_at",direction: "DESC")->get();
    }

    public function mount(){
        $this->fetchNotifications();
    }

    public function render()
    {
        return view('livewire.student.student-notifications');
    }
}
