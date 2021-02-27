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
     * Decide whether a row is a comment or actual data.
     *
     * @param bool
     */
    protected function isComment(array $row)
    {
        return Str::startsWith($row[0], '#');
    }

    /**
     * Decide whether a row should be excluded.
     *
     * @param bool
     */
    protected function isExcluded(array $row)
    {
        return in_array($row[0], self::EXCLUDE);
    }

    /**
     * Decides whether to skip a row or not.
     *
     * @param bool
     */
    public function skip(array $row)
    {
        return $this->isComment($row) || $this->isExcluded($row);
    }

    /**
     * Iterates over the file and returns a LazyCollection which
     * yields the values on every line.
     *
     * @return \Illuminate\Support\LazyCollection
     */
    public function iterable()
    {
        return parent::iterable()->reject([$this, 'skip']);
    }
}
