<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

abstract class Filter
{
    /**
     * Return the model classname to be filtered
     *
     * @return string
     */
    abstract public function modelClass(): string;

    /**
     * The attributes we can use to filter
     *
     * @var array
     */
    abstract public function getAllowedFilters() : array;

    /**
     *
     */
    abstract public function getAllowedIncludes() : array;


    /**
     * The query builder used to apply the filters
     *
     * @return \Spatie\QueryBuilder\QueryBuilder
     */
    public function getBuilder() : QueryBuilder
    {
        return QueryBuilder::for($this->modelClass())
            ->allowedFilters($this->getAllowedFilters())
            ->allowedIncludes($this->getAllowedIncludes());
    }
}
