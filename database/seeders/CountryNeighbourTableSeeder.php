<?php

namespace Database\Seeders;

use App\Imports\NeighbourCountriesImport;
use Illuminate\Database\Seeder;

class CountryNeighbourTableSeeder extends Seeder
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
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new NeighbourCountriesImport($this->filepath))->import();
    }
}
