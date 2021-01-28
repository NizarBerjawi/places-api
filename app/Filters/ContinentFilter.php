<?php

namespace App\Filters;

use App\Models\Continent;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;

class ContinentFilter extends Filter
{
    /**
     * Return the model classname to be filtered
     *
     * @return string
     */
    public function modelClass(): string
    {
        return Continent::class;
    }

    /**
     * The attributes we can use to filter countries
     *
     * @var array
     */
    public function getAllowedFilters() : array
    {
        return [
            AllowedFilter::partial('name'),
            AllowedFilter::exact('code'),
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
