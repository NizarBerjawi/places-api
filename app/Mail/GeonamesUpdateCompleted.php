<?php

namespace App\Mail;

use Illuminate\Bus\Batch;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GeonamesUpdateCompleted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \Illuminate\Bus\Batch
     */
    public $batch;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function __construct(Batch $batch)
    {
        $this->batch = $batch;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.geonames.updateCompleted', [
            'batch' => $this->batch,
        ]);
    }
}
