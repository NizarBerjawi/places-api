<?php

namespace App\Logger;

use Illuminate\Http\Request;
use Illuminate\Log\LogManager;
use Laravel\Lumen\Application;
use Spatie\HttpLogger\DefaultLogWriter;

class LogWriter extends DefaultLogWriter
{
    public function logRequest(Request $request)
    {
        $message = $this->formatMessage($this->getMessage($request));

        $logger = new LogManager(Application::getInstance());
        $logger
            ->channel('http-requests')
            ->info($message);
    }
}
