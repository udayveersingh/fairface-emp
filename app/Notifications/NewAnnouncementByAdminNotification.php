<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class NewAnnouncementByAdminNotification extends Notification
{
    use Queueable;
    public $annoucement;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($annoucement)
    {
        $this->annoucement = $annoucement;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line($this->annoucement['description'])
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'from' => Auth::user()->id,
            'message' => $this->annoucement['description'],
            'user_id' => Auth::user()->id,
            'created_at' => date('Y-m-d H:i:s'),
        ];
    }
}
