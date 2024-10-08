<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketNotification extends Notification
{
    use Queueable;
    protected $user, $ticket, $content;
    /**
     * Create a new notification instance.
     */
    public function __construct($user, $ticket, $content)
    {
        $this->user = $user;
        $this->ticket = $ticket;
        $this->content = $content;
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
                    ->subject('Support Ticket #'.$this->ticket->no)
                    ->markdown('mail.ticket.index', [
                        'user' => $this->user->name,
                        'ticket' =>$this->ticket,
                        'message' => $this->content,
                    ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->ticket->no,
            'message' => $this->content,
        ];
    }
}
