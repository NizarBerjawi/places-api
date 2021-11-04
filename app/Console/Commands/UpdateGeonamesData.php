<?php

namespace App\Console\Commands;

use App\Imports\AlternateNamesDeletesImport;
use App\Imports\AlternateNamesImport;
use App\Imports\DeletesImport;
use App\Imports\PlacesImport;
use App\Jobs\DownloadAlternateNamesDeletesFile;
use App\Jobs\DownloadAlternateNamesModificationsFile;
use App\Jobs\DownloadDeletesFile;
use App\Jobs\DownloadModificationsFile;
use App\Jobs\Traits\HasPlaceholders;
use Carbon\Carbon;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Laravel\Lumen\Application;
use Throwable;

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
        $basePath = storage_path('app/updates');

        (new Filesystem)
            ->ensureDirectoryExists($basePath);

        $date = Carbon::yesterday()->format('Y-m-d');

        // Generate the filenames
        $placesModifications = $this->replace('date', $date, config('geonames.modifications_file'));
        $placesDeletes = $this->replace('date', $date, config('geonames.deletes_file'));
        $alternateNamesModifications = $this->replace('date', $date, config('geonames.alternate_names_modifications_file'));
        $alternateNamesDeletes = $this->replace('date', $date, config('geonames.alternate_names_deletes_file'));

        Application::getInstance()
            ->make(Dispatcher::class)
            ->batch([
                new DownloadModificationsFile($date),
                new DownloadDeletesFile($date),
                new DownloadAlternateNamesModificationsFile($date),
                new DownloadAlternateNamesDeletesFile($date),
            ])->then(function (Batch $batch) use (
                $basePath,
                $placesModifications,
                $placesDeletes,
                $alternateNamesModifications,
                $alternateNamesDeletes
            ) {
                if ($batch->finished()) {
                    dispatch(new PlacesImport("$basePath/$placesModifications"))->onQueue('import-updates');
                    dispatch(new DeletesImport("$basePath/$placesDeletes"))->onQueue('import-updates');
                    dispatch(new AlternateNamesImport("$basePath/$alternateNamesModifications"))->onQueue('import-updates');
                    dispatch(new AlternateNamesDeletesImport("$basePath/$alternateNamesDeletes"))->onQueue('import-updates');
                }
            })
            ->catch(function (Batch $batch, Throwable $e) {
                app()->make(\Illuminate\Mail\Mailer::class)->to('nizarberjawi12@gmail.com')->send(new \App\Mail\GeonamesUpdateFailed());
            })
            ->name('Update Geonames')
            ->onQueue('download-updates')
            ->dispatch();
    }
}
