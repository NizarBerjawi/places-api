<?php

namespace App\Imports\Concerns;

interface GeonamesImportable
{
    /**
     * Import the required data into the database.
     *
     * @return void
     */
    public function import();
}
