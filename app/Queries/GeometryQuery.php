<?php

namespace App\Queries;

use App\Models\Geometry;

class GeometryQuery extends Query
{
    /**
     * Return the model classname to be filtered.
     */
    public function modelClass(): string
    {
        return Geometry::class;
    }

    /**
     * The attributes we can use to filter.
     */
    public function getAllowedFilters(): array
    {
        return [];
    }

    /**
     * The relations that we can include.
     */
    public function getAllowedIncludes(): array
    {
        return [];
    }

    /**
     * The relations that we can sort by.
     */
    public function getAllowedSorts(): array
    {
        return [];
    }
}
