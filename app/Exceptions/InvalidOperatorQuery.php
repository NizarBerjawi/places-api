<?php

namespace App\Exceptions;

use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\Exceptions\InvalidQuery;

class InvalidOperatorQuery extends InvalidQuery
{
    /** @var \Illuminate\Support\Collection */
    public $allowedOperators;

    public function __construct(string $unknownOperator, Collection $allowedOperators, string $type)
    {
        $this->allowedOperators = $allowedOperators;

        $type = Str::plural($type);
        $allowedOperators = $this->allowedOperators->implode(', ');

        $message = "Requested operator `{$unknownOperator}` is not allowed. Allowed operator(s) for {$type} are `{$allowedOperators}`.";

        parent::__construct(Response::HTTP_BAD_REQUEST, $message);
    }
}
