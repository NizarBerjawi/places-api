<?php

namespace Database\Seeders;

use App\Imports\ContinentsImport;
use Illuminate\Database\Seeder;

class ContinentsTableSeeder extends Seeder
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
        $this->filepath = storage_path('app/'.config('geonames.readme_file'));
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        (new ContinentsImport($this->filepath))->import();
    }
}
