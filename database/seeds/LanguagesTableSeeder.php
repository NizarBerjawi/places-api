<?php

use App\Imports\LanguagesImport;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\FilesystemAdapter;

class LanguagesTableSeeder extends Seeder
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
            config('geonames.language_codes_file')
        );
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        (new LanguagesImport($this->filepath))->import();
    }
}
