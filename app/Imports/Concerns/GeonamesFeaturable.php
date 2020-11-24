<?php

namespace App\Imports\Concerns;

interface GeonamesFeaturable
{
    /**
     * The feature code that is being imported from the
     * geonames file
     *
     * @return string
     */
    public function featureCode();
}
