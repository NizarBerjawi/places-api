<?php

namespace App\Filters;

use Illuminate\Pagination\Paginator;
use Spatie\QueryBuilder\QueryBuilder;

abstract class Filter
{
    /**
     * Return the model classname to be filtered.
     *
     * @return string
     */
    abstract public function modelClass(): string;

    /**
     * The attributes we can use to filter.
     *
     * @var array
     */
    abstract public function getAllowedFilters() : array;

    /**
     * The relations that we can include.
     *
     * @var array
     */
    abstract public function getAllowedIncludes() : array;

    /**
     * The query builder used to apply the filters.
     *
     * @return \Illuminate\Pagination\Paginator
     */
    public function getBuilder() : Paginator
    {
        return QueryBuilder::for($this->modelClass())
            ->allowedFilters($this->getAllowedFilters())
            ->allowedIncludes($this->getAllowedIncludes())
            ->simplePaginate(10)
            ->appends(request()->query());
    }
}
