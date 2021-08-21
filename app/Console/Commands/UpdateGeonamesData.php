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
use Illuminate\Bus\Batch;
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
        $dispatcher = app()->make(\Illuminate\Contracts\Bus\Dispatcher::class);
        $date = Carbon::yesterday()->format('Y-m-d');

        // Generate the filenames
        $modifications = $this->replace('date', $date, config('geonames.modifications_file'));
        $deletes = $this->replace('date', $date, config('geonames.deletes_file'));

        $dispatcher->batch([
            new DownloadModificationsFile($date),
            new DownloadDeletesFile($date),
        ])->then(function (Batch $batch) use ($modifications, $deletes) {
            if ($batch->finished()) {
                dispatch(new ModificationsImport(storage_path("app/data/$modifications")))
                    ->onQueue('update');
                dispatch(new DeletesImport(storage_path("app/data/$deletes")))
                    ->onQueue('update');
            }
        })
        ->finally(function (Batch $batch) use ($date) {
            dispatch(new DeleteModificationsFile($date))
                ->onQueue('delete');
            dispatch(new DeleteDeletesFile($date))
                ->onQueue('delete');
        })
        ->onQueue('download')
        ->dispatch();
    }
}
