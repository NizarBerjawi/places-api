<?php

namespace Database\Seeders;

use App\Imports\FlagsImport;
use Illuminate\Database\Seeder;

class FlagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new FlagsImport)->import();
    }
}
