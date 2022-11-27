<?php

namespace App\Filters;

class BooleanFilters extends BaseFilter
{
    public static function description()
    {
        return 'boolean filter';
    }

    public function allowedOperators()
    {
        return [
            'eq' => '=',
            'neq' => '!=',
        ];
    }
}
