<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class SendTimesheetNotificationToAdmin extends Notification
{
    use Queueable;

    public $emp_timesheet;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($emp_timesheet)
    {
        $this->emp_timesheet = $emp_timesheet;
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
                    ->line($this->emp_timesheet['timesheet_id'])
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
            'from' => $this->emp_timesheet['employee_id'],
            'to' => $this->emp_timesheet['supervisor_id'],
            'from_date' => $this->emp_timesheet['start_date'],
            'to_date' => $this->emp_timesheet['end_date'],
            'timesheet_id' => $this->emp_timesheet['timesheet_id'],
            'user_id' => Auth::user()->id,
            'created_at' => date('Y-m-d H:i:s'),
        ];
    }
}
