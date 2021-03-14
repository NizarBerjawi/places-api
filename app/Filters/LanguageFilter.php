<?php

namespace App\Filters;

use App\Models\Language;
use Spatie\QueryBuilder\AllowedFilter;

class LanguageFilter extends Filter
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
     * The attributes we can use to filter countries.
     *
     * @var array
     */
    public function getAllowedFilters() : array
    {
        return [
            AllowedFilter::exact('iso639_1'),
            AllowedFilter::exact('iso639_2'),
            AllowedFilter::exact('iso639_3'),
            AllowedFilter::scope('by_countries'),
        ];
    }

    /**
     * The relations that we can include.
     *
     * @var array
     */
    public function getAllowedIncludes() : array
    {
        return [];
    }
}
