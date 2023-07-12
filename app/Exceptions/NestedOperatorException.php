<?php

namespace App\Exceptions;

use Illuminate\Http\Response;
use Spatie\QueryBuilder\Exceptions\InvalidQuery;

class NestedOperatorException extends InvalidQuery
{
    /** @var \Illuminate\Support\Collection */
    public $allowedOperators;

    public function __construct()
    {
        $message = 'Nested operators are not allowed.';

        parent::__construct(Response::HTTP_BAD_REQUEST, $message);
    }
}
