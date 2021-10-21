<?php

namespace App\Logger;

use Illuminate\Http\Request;
use Spatie\HttpLogger\LogProfile;

class LogGetRequests implements LogProfile
{
    public function shouldLogRequest(Request $request): bool
    {
        return in_array(strtolower($request->method()), ['get']);
    }
}
