<?php

namespace App\Filters;

class StringFilters extends BaseFilter
{
    public static function description()
    {
        return 'string filter';
    }

    public function allowedOperators()
    {
        return [
            'eq' => '=',
            'neq' => '!=',
        ];
    }
}
