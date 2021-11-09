<?php

namespace App\Mail;

use Illuminate\Bus\Batch;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Throwable;

class GeonamesUpdateFailed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \Illuminate\Bus\Batch
     */
    public $batch;

    /**
     * @var \Throwable
     */
    public $exception;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function __construct(Batch $batch, Throwable $e)
    {
        $this->batch = $batch;
        $this->exception = $e;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.geonames.updateFailed', [
            'batch' => $this->batch,
            'exception' => $this->exception,
        ]);
    }
}
