<?php

namespace App\Notifications;

use App\Models\KanbanTask;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskAssigned extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;

    /**
     * Create a new notification instance.
     */
    public function __construct(KanbanTask $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $priority = ucfirst($this->task->priority);
        $dueDate = $this->task->due_date ? $this->task->due_date->format('M d, Y') : 'No due date';
        
        return (new MailMessage)
            ->subject('New Task Assigned to You')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('You have been assigned a new task in your team\'s Kanban board.')
            ->line('Task Details:')
            ->line("Title: {$this->task->title}")
            ->line("Description: {$this->task->description}")
            ->line("Priority: {$priority}")
            ->line("Due Date: {$dueDate}")
            ->action('View Task', url('/dashboard/student/participants'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'title' => $this->task->title,
            'priority' => $this->task->priority,
            'due_date' => $this->task->due_date,
        ];
    }
}