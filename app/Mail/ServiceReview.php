<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ServiceReview extends Mailable {
    use Queueable, SerializesModels;

    public $options;

    public function __construct($options) {
        $this->options = $options;
    }

    public function build() {
        return $this
//            ->bcc('info@art-delight.com')
//            ->bcc('zarovetsky@gmail.com')
            ->subject($this->options['subject'])
            ->view('emails.service-review', ['request'=>$this->options]);
    }

}
