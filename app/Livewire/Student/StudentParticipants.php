<?php

namespace App\Livewire\Student;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StudentParticipants extends Component
{

    public $participants, $authInfo;

    public function mount()
    {
        $this->authInfo = Auth::user();
        $this->participants = User::where('group_no', Auth::user()->group_no)
            ->orderBy("user_type", "ASC")->get();


    }

    public function render()
    {
        return view('livewire.student.student-participants');
    }
}
