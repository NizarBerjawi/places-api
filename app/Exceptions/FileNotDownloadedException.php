<?php

namespace App\Exceptions;

use Exception;

class FileNotDownloadedException extends Exception
{
    /**
     * The location of the file
     *
     * @var string
     */
    public $location;

    /**
     * Instantiate the exception
     *
     * @param string $location
     * @return void
     */
    public function __construct(string $location = null)
    {
        $this->location = $location;

        $defaultMessage = 'Could not download file';

        if (! $location) {
            $this->message = $defaultMessage;
        } else {
            $this->message = $defaultMessage . ' from: ' . $location;
        }
    }
}
