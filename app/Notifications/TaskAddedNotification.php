<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class TaskAddedNotification extends Notification
{
    use Queueable;

    protected $task;
    protected $sessionId;

    /**
     * Create a new notification instance.
     */
    public function __construct($task, $sessionId)
    {
        $this->task = $task;
        $this->sessionId = $sessionId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        // Convert due_date to Carbon instance if it's not already one
        $dueDate = Carbon::parse($this->task->due_date);

        return (new MailMessage)
            ->line('A new task has been assigned: ' . $this->task->name)
            ->line('Description: ' . $this->task->description)
            ->line('Due date: ' . $dueDate->format('F j, Y')) // Format the due date
            ->action('View Task', route('sessions.tasks.show', ['session' => $this->sessionId, 'task' => $this->task->id])) 
            ->line('Thank you for using our application!')
            ->line('Good luck with your task!');
    }

    /**
     * Get the array representation of the notification for the database.
     *
     * @return array<string, mixed>
     */
    public function toDatabase($notifiable)
    {
        // Convert due_date to Carbon instance for consistent formatting
        $dueDate = Carbon::parse($this->task->due_date);

        return [
            'task_id' => $this->task->id,
            'task_name' => $this->task->name,
            'task_description' => $this->task->description,
            'task_due_date' => $dueDate->format('F j, Y'), 
            'session_id' => $this->sessionId
        ];
    }
}
