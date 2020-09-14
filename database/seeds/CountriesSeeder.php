<?php

use App\Jobs\DownloadCountriesFile;
use App\Jobs\ImportCountriesFile;
use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DownloadCountriesFile::dispatch();
        ImportCountriesFile::dispatch();
    }
}
