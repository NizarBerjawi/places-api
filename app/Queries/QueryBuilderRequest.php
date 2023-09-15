<?php

namespace App\Queries;

use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilderRequest as SpatieRequest;

class QueryBuilderRequest extends SpatieRequest
{
    public function filters(): Collection
    {
        $filterParameterName = config('query-builder.parameters.filter');

        $filterParts = $this->getRequestData($filterParameterName, []);

        if (is_string($filterParts)) {
            $filterParts = json_decode($filterParts, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return collect();
            }
        }

        $filters = collect($filterParts);

        return $filters->map(function ($value) {
            return $this->getFilterValue($value);
        });
    }
}
