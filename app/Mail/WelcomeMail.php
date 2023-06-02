<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $emp_job_detail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emp_job_detail)
    {
        $this->emp_job_detail = $emp_job_detail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('backend.job-email');
    }
}
