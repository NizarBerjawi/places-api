<?php

use App\Imports\PlacesImport;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\FilesystemAdapter;

class PlacesTableSeeder extends Seeder
{
    /**
     * The Storage disk.
     *
     * @var \Illuminate\Filesystem\FilesystemAdapter
     */
    public $storage;

    /**
     * Initialize an instance of the seeder.
     *
     * @param \Illuminate\Filesystem\FilesystemAdapter  $storage
     * @return void
     */
    public function __construct(FilesystemAdapter $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Country::cursor()
            ->each(function (Country $country) {
                $code = $country->iso3166_alpha2;

                $filepath = $this->storage->path(
                    $code.'/'.$code.'.txt'
                );

                (new PlacesImport($filepath))->import();
            });
    }
}
