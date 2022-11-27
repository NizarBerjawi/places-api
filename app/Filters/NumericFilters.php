<?php

namespace App\Filters;

class NumericFilters extends BaseFilter
{
    public static function description()
    {
        return 'numeric filter';
    }

    public function allowedOperators()
    {
        return [
            'eq' => '=',
            'neq' => '!=',
            'gt' => '>',
            'gte' => '>=',
            'lt' => '<',
            'lte' => '<=',
        ];
    }
}
