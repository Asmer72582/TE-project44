<?php

namespace App\Livewire\Instructor;

use App\Models\KanbanTask;
use App\Models\User;
use App\Notifications\TaskAssigned;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Exception;

class InstructorParticipants extends Component
{
    public $title;
    public $description;
    public $assigned_to;
    public $due_date;
    public $priority = 'medium';
    public $tasks = [];
    public $participants = [];
    public $isProcessing = false;

    protected $rules = [
        'title' => 'required|min:3',
        'description' => 'required|min:10',
        'assigned_to' => 'required|exists:users,id',
        'due_date' => 'nullable|date|after:today',
        'priority' => 'required|in:low,medium,high',
    ];

    public function mount()
    {
        $this->loadParticipants();
        $this->loadTasks();
    }

    private function extractGroupNumber($groupString)
    {
        return (int) preg_replace('/[^0-9]/', '', $groupString);
    }

    private function loadParticipants()
    {
        // Get instructor's group number
        $instructorGroupNo = Auth::user()->group_no;
        
        // Get students from the same group
        $this->participants = User::where('group_no', $instructorGroupNo)
            ->where('user_type', 'student')
            ->orderBy('name')
            ->get();
    }

    public function createTask()
    {
        $this->isProcessing = true;

        try {
            $this->validate();

            $groupNo = $this->extractGroupNumber(Auth::user()->group_no);

            $task = KanbanTask::create([
                'title' => $this->title,
                'description' => $this->description,
                'status' => 'todo',
                'group_no' => $groupNo,
                'assigned_to' => $this->assigned_to,
                'created_by' => Auth::id(),
                'due_date' => $this->due_date,
                'priority' => $this->priority,
            ]);

            // Send notification to assigned user
            $assignedUser = User::find($this->assigned_to);
            if ($assignedUser) {
                $assignedUser->notify(new TaskAssigned($task));
            }

            $this->reset(['title', 'description', 'assigned_to', 'due_date', 'priority']);
            $this->loadTasks();

            $this->dispatch('task-created', [
                'message' => 'Task created successfully!'
            ]);
        } catch (Exception $e) {
            $this->dispatch('task-error', [
                'message' => 'Error creating task. Please try again.'
            ]);
        } finally {
            $this->isProcessing = false;
        }
    }

    public function loadTasks()
    {
        $groupNo = $this->extractGroupNumber(Auth::user()->group_no);
        
        $allTasks = KanbanTask::with(['assignedTo', 'createdBy'])
            ->where('group_no', $groupNo)
            ->get();

        $this->tasks = [
            'todo' => $allTasks->where('status', 'todo'),
            'in_progress' => $allTasks->where('status', 'in_progress'),
            'done' => $allTasks->where('status', 'done'),
        ];
    }

    public function updateTaskStatus($taskId, $newStatus)
    {
        $task = KanbanTask::find($taskId);
        if ($task) {
            $task->update(['status' => $newStatus]);
            $this->loadTasks();
            
            $this->dispatch('task-updated', [
                'message' => 'Task status updated successfully!'
            ]);
        }
    }

    public function deleteTask($taskId)
    {
        $task = KanbanTask::find($taskId);
        if ($task) {
            $task->delete();
            $this->loadTasks();
            
            $this->dispatch('task-deleted', [
                'message' => 'Task deleted successfully!'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.instructor.instructor-participants');
    }
}
