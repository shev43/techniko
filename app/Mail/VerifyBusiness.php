<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyBusiness extends Mailable {
    use Queueable, SerializesModels;

    public $options;

    public function __construct($options) {
        $this->options = $options;
    }

    public function build() {
        return $this
//            ->bcc('zarovetsky@gmail.com')
            ->subject($this->options['subject'])
            ->view('emails.verify-business', ['request'=>$this->options]);
    }

}
