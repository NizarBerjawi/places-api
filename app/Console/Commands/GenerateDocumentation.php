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
    protected $signature = 'docs:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate up-to-date API documentation';

    /**
     * Execute the console command.
     *
     * @param  \App\Support\DripEmailer  $drip
     * @return mixed
     */
    public function handle()
    {
        $openApi = Generator::scan(['app/Http/Controllers', 'app/Models']);
        $content = $openApi->toJson();

        (new Filesystem)->put(base_path('openApi.json'), $content);
    }
}
