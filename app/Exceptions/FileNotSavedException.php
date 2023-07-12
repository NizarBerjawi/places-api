<?php

namespace App\Exceptions;

use Exception;

class FileNotSavedException extends Exception
{
    /**
     * The location to save the file.
     *
     * @var string
     */
    public $location;

    /**
     * Instantiate the exception.
     *
     * @param  string  $filename
     * @return void
     */
    public function __construct(string $location = null)
    {
        $this->location = $location;

        $defaultMessage = 'Could not save file to disk';

        if (! $location) {
            $this->message = $defaultMessage;
        } else {
            $this->message = $defaultMessage.': '.$location;
        }
    }
}
