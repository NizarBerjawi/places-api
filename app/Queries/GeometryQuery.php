<?php

namespace App\Queries;

use App\Models\Geometry;

class GeometryQuery extends Query
{
    /**
     * Return the model classname to be filtered.
     *
     * @return string
     */
    public function modelClass(): string
    {
        return Geometry::class;
    }

    /**
     * The attributes we can use to filter.
     *
     * @return array
     */
    public function getAllowedFilters(): array
    {
        return [];
    }

    /**
     * The relations that we can include.
     *
     * @return array
     */
    public function getAllowedIncludes(): array
    {
        return [];
    }

    /**
     * The relations that we can sort by.
     *
     * @return array
     */
    public function getAllowedSorts(): array
    {
        return [];
    }
}
