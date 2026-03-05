<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPassword extends Mailable {
    use Queueable, SerializesModels;

    public $options;

    public function __construct($options) {
        $this->options = $options;
    }

    public function build() {
        return $this
//            ->bcc('info@art-delight.com')
//            ->bcc('zarovetsky@gmail.com')
//            ->bcc('test-ly6gsen3x@srv1.mail-tester.com')
            ->subject($this->options['subject'])
            ->view('emails.forgot-password', ['request'=>$this->options]);
    }

}
