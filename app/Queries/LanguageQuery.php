<?php

namespace App\Queries;

use App\Models\Language;
use Spatie\QueryBuilder\AllowedFilter;

class LanguageQuery extends Query
{
    /**
     * Return the model classname to be filtered.
     *
     * @return string
     */
    public function modelClass(): string
    {
        return Language::class;
    }

    /**
     * The attributes we can use to filter.
     *
     * @return array
     */
    public function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('iso639.1', 'iso639_1'),
            AllowedFilter::exact('iso639.2', 'iso639_2'),
            AllowedFilter::exact('iso639.3', 'iso639_3'),
            AllowedFilter::scope('countryCode', 'by_country'),
        ];
    }

    /**
     * The relations that we can include.
     *
     * @return array
     */
    public function getAllowedIncludes(): array
    {
        return ['countries'];
    }

    public function getAllowedSorts(): array
    {
        return [
            'name', 'iso639.1', 'iso639.2', 'iso639.3',
        ];
    }
}
