<?php

namespace App\Queries;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder as SpatieBuilder;

class QueryBuilder extends SpatieBuilder
{
    protected function initializeRequest(Request $request = null): static
    {
        $this->request = QueryBuilderRequest::fromRequest($request);

        return $this;
    }
}
