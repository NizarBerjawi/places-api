<?php

namespace App\Exceptions;

use Exception;

class FileNotDownloadedException extends Exception
{
    /**
     * The name of the file
     * 
     * @var string
     */
    public $filename;

    /**
     * Instantiate the exception
     * 
     * @param string $filename
     * @return void
     */
    public function __construct(string $filename = null)
    {
        $this->filename = $filename;  

        $defaultMessage = 'Could not download file';

        if (! $filename) {
            $this->message = $defaultMessage;
        } else {
            $this->message = $defaultMessage . ': ' . $filename;
        }
    }
}
