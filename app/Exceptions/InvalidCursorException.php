<?php

namespace App\Exceptions;

use Illuminate\Http\Response;
use Spatie\QueryBuilder\Exceptions\InvalidQuery;

class InvalidCursorException extends InvalidQuery
{
    public function __construct()
    {
        $message = 'Invalid cursor paginator provided.';

        parent::__construct(Response::HTTP_BAD_REQUEST, $message);
    }
}
