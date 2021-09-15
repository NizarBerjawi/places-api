<?php

namespace App\Queries;

use App\Models\FeatureClass;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;

class FeatureClassQuery extends Query
{
    /**
     * Return the model classname to be filtered.
     *
     * @return string
     */
    public function modelClass(): string
    {
        return FeatureClass::class;
    }

    /**
     * The attributes we can use to filter.
     *
     * @return array
     */
    public function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('code'),
        ];
    }

    /**
     * The relations that we can include.
     *
     * @return array
     */
    public function getAllowedIncludes(): array
    {
        return [
            AllowedInclude::relationship('featureCodes'),
        ];
    }

    public function getAllowedSorts(): array
    {
        return ['code', 'description'];
    }
}
