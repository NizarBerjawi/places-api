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

    public function getMessage(Request $request)
    {
        return [
            'method' => strtoupper($request->getMethod()),
            'uri' => $request->getRequestUri(),
            'ip' => $request->getClientIp(),
        ];
    }

    protected function formatMessage(array $message)
    {
        return "{$message['method']} {$message['uri']} - IP: {$message['ip']}";
    }
}
