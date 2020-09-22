<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketNotification extends Notification
{
    use Queueable;
    protected $ticket, $admin;


    /**
     * Create a new notification instance.
     *
     * @param $ticket
     * @param $admin
     */
    public function __construct($ticket, $admin)
    {
        $this->ticket = $ticket;
        $this->admin = $admin;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        if ($this->admin == 'true')
            return (new MailMessage)
                ->level('info')
                ->line('پیام جدید در پشتیبانی" ')
                ->action('دیدن پیام', route('admin.ticketShow', $this->ticket->id));
        else
            return (new MailMessage)
                ->level('info')
                ->line('شما یک پیام جدید برای موضوع " '.$this->ticket->title.' " از طرف سایت دریافت کردید.')
                ->action('دیدن پیام', route('tickets.show', $this->ticket->id));

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
