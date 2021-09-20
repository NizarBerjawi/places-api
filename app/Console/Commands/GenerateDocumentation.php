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

        $path = "app/Http/Controllers/Api/$apiVersion/spec/constants.php";

        $filesystem = new Filesystem();

        if (! $filesystem->exists($path)) {
            return $this->error('Failed to generate documentation');
        }

        require_once $path;

        $content = Generator::scan(['app/Http/Controllers', 'app/Models', 'app/Queries'])
            ->toJson();

        (new Filesystem)->put(public_path('openApi.json'), $content);
    }
}
