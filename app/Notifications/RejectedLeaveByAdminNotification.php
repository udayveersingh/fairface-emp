<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class RejectedLeaveByAdminNotification extends Notification
{
    use Queueable;

    public $leave_status;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($leave_status)
    {
        $this->leave_status = $leave_status;
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
                    ->line($this->leave_status['type'])
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
            'from' => $this->leave_status['from'],
            'to' => $this->leave_status['to'],
            'message' => $this->leave_status['message'],
            'approved_date_time' =>$this->leave_status['approved_date_time'],
            'user_id' => Auth::user()->id,
            'created_at' =>date('Y-m-d H:i:s'),
            'status' => 'active',
        ];
    }
}
