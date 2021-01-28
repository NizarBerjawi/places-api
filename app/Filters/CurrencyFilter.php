<?php

namespace App\Filters;

use App\Models\Currency;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;

class CurrencyFilter extends Filter
{
    /**
     * Return the model classname to be filtered
     *
     * @return string
     */
    public function modelClass(): string
    {
        return Currency::class;
    }

    /**
     * The attributes we can use to filter countries
     *
     * @var array
     */
    public function getAllowedFilters() : array
    {
        return [
            AllowedFilter::exact('code'),
            AllowedFilter::partial('name')
        ];
    }

    /**
     *
     */
    public function getAllowedIncludes() : array
    {
        return [
            AllowedInclude::relationship('countries')
        ];
    }
}
