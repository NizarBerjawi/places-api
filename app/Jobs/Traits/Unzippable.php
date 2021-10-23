<?php

namespace App\Jobs\Traits;

use App\Jobs\GeonamesJob;
use Exception;

trait Unzippable
{
    /**
     * Unzip all downloaded Geoname files.
     *
     * @return void
     */
    protected function unzip()
    {
        if (! $this instanceof GeonamesJob) {
            throw new Exception('Must be an instance of GeonamesJob.');
        }

        $zip = new \ZipArchive();

        $res = $zip->open($this->filepath());

        if (! $res) {
            throw new \Exception('Could not unzip file: '.$this->fileName());
        }

        $zip->extractTo($this->folderPath());
        $zip->close();
    }

    /**
     * The location where to unzip the archive.
     *
     * @return string
     */
    abstract public function folderPath();
}
