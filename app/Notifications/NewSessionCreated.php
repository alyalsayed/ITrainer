<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;


class NewSessionCreated extends Notification 
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
                    ->subject('New Session Created')
                    ->line('A new session has been created.')
                    ->line('Session Name: ' . $this->session->name)
                    ->line('Session Date: ' . $this->session->session_date->format('Y-m-d'))
                    ->line('Location: ' . $this->session->location)
                    ->action('View Session', route('sessions.show', $this->session->id))
                    ->line('Thank you for using our application!');
    }

   
    public function toDatabase($notifiable)
    {
        $session_date = Carbon::parse($this->session->session_date);

        return [
            'session_id' => $this->session->id,
            'session_name' => $this->session->name,
            'session_date' => $session_date->format('F j, Y'),
            'location' => $this->session->location,
        ];
    }
}


