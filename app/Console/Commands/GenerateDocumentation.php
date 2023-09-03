<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use OpenApi\Generator;

class GenerateDocumentation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docs:generate {--apiVersion=v1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate up-to-date API documentation';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $apiVersion = strtoupper($this->option('apiVersion'));

        if (! $apiVersion) {
            return $this->error('You must provide an apiVersion value.');
        }

        $path = app_path("Http/Controllers/Api/$apiVersion/Spec/constants.php");

        if ((new Filesystem)->missing($path)) {
            return $this->error('Failed to generate documentation');
        }

        // We import all the constants right before we
        // initiate scanning of files.
        require_once $path;

        $content = Generator::scan([
            app_path('Http/Controllers'),
            app_path('Models'),
            app_path('Queries'),
            app_path('Filters'),
        ])->toJson();

        (new Filesystem)->put(public_path('openApi.json'), $content);
    }
}
