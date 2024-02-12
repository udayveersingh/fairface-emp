<?php 
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Employee; // Import the Employee model if not already imported
use Illuminate\Support\Facades\Auth;

class DocumentExpireNotification extends Notification
{
    protected $employee;
    protected $content;

    public function __construct(Employee $employee, array $content)
    {
        $this->employee = $employee;
        $this->content = $content;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject($this->content['subject_type'])
                    ->line($this->content['name'])
                    ->line($this->content['subject'])
                    ->line($this->content['regards']);
    }

    public function toArray($notifiable)
    {
        return [
            'from' => Auth::user()->id, // Assuming this is correct
            'to' => $this->employee->id, // Assuming this is correct
            'user_id' => $notifiable->id, // Assuming you're passing the user as notifiable
            'message' => $this->content['subject'],
            'created_at' => now()->toDateTimeString(),
        ];
    }
}
