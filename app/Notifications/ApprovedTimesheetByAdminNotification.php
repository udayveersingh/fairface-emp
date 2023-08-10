<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ApprovedTimesheetByAdminNotification extends Notification
{
    use Queueable;
    public $notification_message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notification_message)
    {
        $this->notification_message = $notification_message;
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
                    ->line($this->notification_message['message'])
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
            'from' => $this->notification_message['from'],
            'to' => $this->notification_message['to'],
            'message' => $this->notification_message['message'],
            'approved_date_time' =>$this->notification_message['approved_date_time'],
            'user_id' => Auth::user()->id,
            'created_at' => date('Y-m-d H:i:s'),
            'status' =>'active',
        ];
     }
  }
