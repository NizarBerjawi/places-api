<?php

use App\Imports\CountryCurrencyImport;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\FilesystemAdapter;

class CountryCurrencyTableSeeder extends Seeder
{

    /**
     * The path of the file to be imported
     *
     * @var string
     */
    public $filepath;

    /**
     * Initialize an instance of the seeder
     *
     * @param \Illuminate\Filesystem\FilesystemAdapter  $storage
     * @return void
     */
    public function __construct(FilesystemAdapter $storage)
    {
        $this->filepath = $storage->path(
            config('geonames.countries_file')
        );
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
