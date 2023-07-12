<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Log\LogManager;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Psr\Log\LoggerInterface;

abstract class GeonamesJob implements ShouldQueue
{
    /*
    |--------------------------------------------------------------------------
    | Queueable Jobs
    |--------------------------------------------------------------------------
    |
    | This job base class provides a central location to place any logic that
    | is shared across all of your jobs. The trait included with the class
    | provides access to the "queueOn" and "delay" queue helper methods.
    |
    */

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds before a request timesout
     *
     * @var int
     */
    const TIMEOUT = 300;

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
    }

    /**
     * Log any error messages.
     *
     * @return string
     */
    protected function log($message, $level)
    {
        $logger = new LogManager(Application::getInstance());

        if (! method_exists(LoggerInterface::class, $level)) {
            throw new \Exception('Log level is not allowed');
        }

        $logger->{$level}($message);
    }

    /**
     * The location of the file.
     *
     * @return string
     */
    abstract public function url();

    /**
     * The name of the file.
     *
     * @return string
     */
    abstract public function filename();

    /**
     * The location where the file should be stored.
     *
     * @return string
     */
    abstract public function filepath();
}
