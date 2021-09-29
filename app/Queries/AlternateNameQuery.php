<?php

namespace App\Queries;

use App\Models\AlternateName;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;

class AlternateNameQuery extends Query
{
    /**
     * Return the model classname to be filtered.
     *
     * @return string
     */
    public function modelClass(): string
    {
        return AlternateName::class;
    }

    /**
     * The attributes we can use to filter.
     *
     * @return array
     */
    public function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('name'),
            AllowedFilter::exact('isPreferredName', 'is_preferred_name'),
            AllowedFilter::exact('isShortName', 'is_short_name'),
            AllowedFilter::scope('languageCodes', 'byLanguageCode'),
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
            AllowedInclude::relationship('language'),
            AllowedInclude::relationship('place'),
        ];
    }

    public function getAllowedSorts(): array
    {
        return [
            AllowedSort::field('name'),
            AllowedSort::field('featureCode', 'feature_code'),
            AllowedSort::field('countryCode', 'country_code'),
            AllowedSort::field('timeZoneCode', 'time_zone_code'),
            AllowedSort::field('population'),
            AllowedSort::field('elevation'),
        ];
    }
}
