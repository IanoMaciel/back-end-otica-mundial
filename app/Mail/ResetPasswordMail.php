<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable {
    use Queueable, SerializesModels;

    public $token;
    public $email;

    public function __construct($token, $email) {
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * @return ResetPasswordMail
     */
    public function build(): ResetPasswordMail {
        return $this->view('emails.reset_password')
            ->with([
                'token' => $this->token,
                'email' => $this->email
            ]);
    }
}
