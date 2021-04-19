<?php

namespace Database\Seeders;

use App\Imports\CountryCurrencyImport;
use Illuminate\Database\Seeder;

class CountryCurrencyTableSeeder extends Seeder
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
        (new CountryCurrencyImport($this->filepath))->import();
    }
}
