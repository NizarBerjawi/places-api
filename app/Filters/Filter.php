<?php

namespace App\Filters;

interface Filter
{
    /**
     * The attributes we can use to filter
     *
     * @var array
     */
    public function getAllowedFilters();

    /**
     * The query builder used to apply the filters
     *
     * @return \Spatie\QueryBuilder\QueryBuilder
     */
    public function getBuilder();
}
