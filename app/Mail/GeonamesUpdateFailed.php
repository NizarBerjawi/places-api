<?php

namespace App\Mail;

use Illuminate\Bus\Batch;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GeonamesUpdateFailed extends Mailable
{
    use Queueable, SerializesModels;

    // /**
    //  *
    //  */
    // public $batch;

    // /**
    //  *
    //  */
    // public $message;

    // /**
    //  * Create a new message instance.
    //  *
    //  * @param  \App\Models\Order  $order
    //  * @return void
    //  */
    // public function __construct(Batch $batch, string $message)
    // {
    //     $this->batch = $batch;
    //     $this->$message = $message;
    // }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.geonames.updateFailed');
    }
}
