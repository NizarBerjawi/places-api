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
use App\Mail\GeonamesUpdateCompleted;
use App\Mail\GeonamesUpdateFailed;
use Carbon\Carbon;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Mail\Mailer;
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

        $app = Application::getInstance();

        $app
            ->make(Dispatcher::class)
            ->batch([
                new DownloadModificationsFile($date),
                new PlacesImport("$basePath/$placesModifications"),
                new DownloadDeletesFile($date),
                new DeletesImport("$basePath/$placesDeletes"),
                new DownloadAlternateNamesModificationsFile($date),
                new AlternateNamesImport("$basePath/$alternateNamesModifications"),
                new DownloadAlternateNamesDeletesFile($date),
                new AlternateNamesDeletesImport("$basePath/$alternateNamesDeletes"),
            ])->then(function (Batch $batch) {
                if ($batch->finished()) {
                    Application::getInstance()
                        ->make(Mailer::class)
                        ->to(config('mail.mailers.smtp.username'))
                        ->send(new GeonamesUpdateCompleted($batch));
                }
            })
            ->catch(function (Batch $batch, Throwable $e) {
                Application::getInstance()
                    ->make(Mailer::class)
                    ->to(config('mail.mailers.smtp.username'))
                    ->send(new GeonamesUpdateFailed($batch, $e));
            })
            ->onQueue('download-updates')
            ->dispatch();
    }
}
