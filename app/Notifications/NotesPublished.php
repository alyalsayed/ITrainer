<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotesPublished extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
   
    protected $session;

    /**
     * Create a new notification instance.
     */
    public function __construct( $session)
    {
        $this->session = $session;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Notes Published for ' . $this->session->name)
            ->line('Notes for the session "' . $this->session->name . '" have been published.')
            ->line('You can now review all notes and materials from the session.')
            ->action('View All Notes', route('notes.index', $this->session->id)) 
            ->line('Thank you for staying updated!');
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'session_name' => $this->session->name,
            'session_id' => $this->session->id,
            'published_at' => now(),
            'message' => 'Notes for the session "' . $this->session->name . '" have been published.',
            'url' => route('notes.index', $this->session->id) 
        ];
    }
}
