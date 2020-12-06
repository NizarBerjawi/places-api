<?php

namespace App\Imports\Iterators;

use Illuminate\Support\Str;

class CountriesFileIterator extends BaseIterator
{
    /**
     * Dissolved countries that don't exist any more.
     *
     * @var array
     */
    const EXCLUDE = ['CS', 'AN'];
    
    /**
     * Decide whether a row is a comment or actual data
     *
     * @param boolean
     */
    protected function isComment(array $row)
    {
        return Str::startsWith($row[0], '#');
    }

    /**
     * Decide whether a row should be excluded
     *
     * @param boolean
     */
    protected function isExcluded(array $row)
    {
        return in_array($row[0], self::EXCLUDE);
    }

    /**
     * Decides whether to skip a row or not
     *
     * @param boolean
     */
    public function skip(array $row)
    {
        return $this->isComment($row) || $this->isExcluded($row);
    }
}
