<?php

namespace App\Console\Commands;

use App\Imports\DeletesImport;
use App\Imports\ModificationsImport;
use App\Jobs\DeleteDeletesFile;
use App\Jobs\DeleteModificationsFile;
use App\Jobs\DownloadDeletesFile;
use App\Jobs\DownloadModificationsFile;
use App\Jobs\Traits\HasPlaceholders;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateGeonamesData extends Command
{
    use HasPlaceholders;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geonames:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the geonames data';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $date = Carbon::yesterday()->format('Y-m-d');

        dispatch(new DownloadModificationsFile($date));
        dispatch(new DownloadDeletesFile($date));

        $modifications = $this->replace('date', $date, config('geonames.modifications_file'));
        (new ModificationsImport(storage_path("app/$modifications")))->import();

        $deletes = $this->replace('date', $date, config('geonames.deletes_file'));
        (new DeletesImport(storage_path("app/$deletes")))->import();

        dispatch(new DeleteModificationsFile($date));
        dispatch(new DeleteDeletesFile($date));
    }
}
