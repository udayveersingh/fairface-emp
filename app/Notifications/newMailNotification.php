<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class newMailNotification extends Notification
{
    use Queueable;

    public $company_email;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($company_email)
    {
        $this->company_email = $company_email;
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
                    ->line($this->company_email['body'])
                    ->action('Notification Action', url('/company-email'))
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
            'company_email' => $this->company_email['id'],
            'from' => $this->company_email['from_id'],
            'to' => $this->company_email['to_id'],
            'subject' => $this->company_email['subject'],
            'body' => $this->company_email['body'],
            'attachment' => $this->company_email['attachment'],
        ];
    }
}
