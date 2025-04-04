<?php

namespace App\Livewire\Student;

use App\Models\User;
use App\Models\KanbanTask;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StudentParticipants extends Component
{
    public $participants;
    public $authInfo;
    public $tasks;
    
    // Form fields
    public $title;
    public $description;
    public $status = 'todo';
    public $assigned_to;
    public $due_date;
    public $priority = 'medium';

    protected $rules = [
        'title' => 'required|min:3',
        'description' => 'nullable',
        'status' => 'required|in:todo,in_progress,done',
        'assigned_to' => 'nullable|exists:users,id',
        'due_date' => 'nullable|date|after_or_equal:today',
        'priority' => 'required|in:low,medium,high'
    ];

    protected $listeners = ['updateTaskOrder', 'taskMoved'];

    private function extractGroupNumber($groupString) {
        // Remove any non-numeric characters from the group string
        return (int) preg_replace('/[^0-9]/', '', $groupString);
    }

    public function taskMoved($taskId, $newStatus)
    {
        $this->updateTaskStatus($taskId, $newStatus);
    }

    public function updateTaskOrder($items)
    {
        foreach ($items as $item) {
            KanbanTask::find($item['value'])->update(['order' => $item['order']]);
        }
    }

    public function createTask()
    {
        $this->validate();

        $groupNo = $this->extractGroupNumber(Auth::user()->group_no);

        // Get max order for the status
        $maxOrder = KanbanTask::where('status', $this->status)
            ->where('group_no', $groupNo)
            ->max('order') ?? 0;

        KanbanTask::create([
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'group_no' => $groupNo,
            'assigned_to' => $this->assigned_to,
            'created_by' => Auth::id(),
            'due_date' => $this->due_date,
            'priority' => $this->priority,
            'order' => $maxOrder + 1
        ]);

        $this->reset(['title', 'description', 'status', 'assigned_to', 'due_date', 'priority']);
        $this->dispatch('task-created', ['message' => 'Task created successfully']);
        $this->loadTasks();
    }

    public function updateTaskStatus($taskId, $newStatus)
    {
        $task = KanbanTask::find($taskId);
        if ($task && in_array($newStatus, ['todo', 'in_progress', 'done'])) {
            // Get max order for the new status
            $groupNo = $this->extractGroupNumber(Auth::user()->group_no);
            $maxOrder = KanbanTask::where('status', $newStatus)
                ->where('group_no', $groupNo)
                ->max('order') ?? 0;

            $task->update([
                'status' => $newStatus,
                'order' => $maxOrder + 1
            ]);
            
            $this->loadTasks();
            $this->dispatch('task-updated', ['message' => 'Task status updated']);
        }
    }

    public function deleteTask($taskId)
    {
        $task = KanbanTask::find($taskId);
        if ($task) {
            $task->delete();
            $this->loadTasks();
            $this->dispatch('task-deleted', ['message' => 'Task deleted successfully']);
        }
    }

    public function loadTasks()
    {
        $groupNo = $this->extractGroupNumber(Auth::user()->group_no);
        
        $tasks = KanbanTask::where('group_no', $groupNo)
            ->with(['assignedTo', 'createdBy'])
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

        // Group tasks by status
        $this->tasks = [
            'todo' => $tasks->where('status', 'todo')->values(),
            'in_progress' => $tasks->where('status', 'in_progress')->values(),
            'done' => $tasks->where('status', 'done')->values()
        ];
    }

    public function mount()
    {
        $this->authInfo = Auth::user();
        $this->participants = User::where('group_no', Auth::user()->group_no)
            ->orderBy("user_type", "ASC")->get();
        $this->loadTasks();
    }

    public function render()
    {
        return view('livewire.student.student-participants');
    }
}
