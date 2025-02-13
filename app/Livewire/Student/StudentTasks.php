<?php

namespace App\Livewire\Student;

use App\Models\Notifications;
use Livewire\Component;
use App\Models\Proposals;
use App\Models\Repositories;
use App\Models\Tasks;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class StudentTasks extends Component
{

    public $tasks,$group_no;

    public $folders = [];

    public $task_folder;

    public function update_task_folder($task_id, $folder_id)
    {
        try {

            $task_completed_date = Date::today();

            if (strtolower($folder_id) == "select") {
                $folder_id = null;
                $task_completed_date = null;
            }

            $task = Tasks::where('task_id', $task_id)->first();
            $task->update(['task_folder' => $folder_id, "task_completed_date" => $task_completed_date]);

            $this->dispatch("tasks", [ "message" => "Your work submitted.", "type" => "success", "title" => "Submitted"]);

            if($folder_id !== null){
                $new_notification = new Notifications([
                    "group_no" => Auth::user()->group_no,
                    "notification_title" => "Task Submission Update",
                    "notification_message" => "Task - " . $task->task_title . " Submitted! "
                ]);
                $new_notification->save();
            }

        } catch (Exception $e) {
            dd($e);
        }
        $this->FetchTasks();
    }

    public function FetchTasks()
    {
        $this->tasks = Tasks::where("group_no", Auth::user()->group_no)->orderBy("week_no", "ASC")->get();
        // dd($this->tasks);
    }

    public function fetchAll()
    {
        $this->folders = Repositories::where("group_no", Auth::user()->group_no)->where("is_folder", 1)->get();
    }

    public function mount()
    {
        $this->group_no = Auth::user()->group_no;
        $this->FetchTasks();
        $this->fetchAll();
    }

    public function render()
    {
        return view('livewire.student.student-tasks');
    }
}
