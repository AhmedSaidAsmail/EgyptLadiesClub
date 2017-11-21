<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class registerConfirmation extends Mailable {

    protected $id;
    protected $rand_code;

    use Queueable,
        SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id, $rand_code) {
        $this->id = $id;
        $this->rand_code = $rand_code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this
                        ->subject('Egypt Ladies Club')
                        ->from('no-replay@sharm4all.com','EgyptLadiesClub Confirm Mail')
                        ->view('Mail.registerConfirmation')
                        ->with(['id' => $this->id, 'rand_code' => $this->rand_code]);
    }

}
