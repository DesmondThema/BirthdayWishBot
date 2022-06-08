<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HappyBirthday extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($employee)
    {
        $this->employee = $employee;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): HappyBirthday
    {
        return $this->view('birthday_wishes');
    }
}
