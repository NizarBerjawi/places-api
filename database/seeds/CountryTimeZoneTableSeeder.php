<?php

use App\Imports\CountryTimeZoneImport;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\FilesystemAdapter;

class CountryTimeZoneTableSeeder extends Seeder
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
     * @param \Illuminate\Filesystem\FilesystemAdapter  $storage
     * @return void
     */
    public function __construct(FilesystemAdapter $storage)
    {
        $this->filepath = $storage->path(
            config('geonames.time_zones_file')
        );
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new CountryTimeZoneImport($this->filepath))->import();
    }
}
