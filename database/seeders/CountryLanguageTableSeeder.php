<?php

namespace Database\Seeders;

use App\Imports\CountryLanguageImport;
use Illuminate\Database\Seeder;

class CountryLanguageTableSeeder extends Seeder
{
    /**
     * The path of the file to be imported.
     *
     * @var string
     */
    public $filepath;

    /**
     * Initialize an instance of the seeder.
     *
     * @return void
     */
    public function __construct()
    {
        $this->filepath = storage_path('app/'.config('geonames.countries_file'));
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        (new CountryLanguageImport($this->filepath))->import();
    }
}
