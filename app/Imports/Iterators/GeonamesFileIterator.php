<?php

namespace App\Imports\Iterators;

use App\Imports\Concerns\GeonamesFeaturable;

class GeonamesFileIterator extends BaseIterator implements GeonamesFeaturable
{
    /**
     * The feature code being imported
     *
     * @return string
     */
    public function featureCode()
    {
        return '';
    }

    /**
     * Decides whether to skip a row or not
     *
     * @param boolean
     */
    public function skip(array $row)
    {
        if (empty($this->featureCode())) {
            return false;
        }

        return isset($row[7]) && $this->featureCode() !== $row[7];
    }
}
