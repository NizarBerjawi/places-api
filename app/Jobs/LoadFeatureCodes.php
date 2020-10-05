<?php

namespace App\Jobs;

use App\Exceptions\FileNotDownloadedException;
use App\Feature;
use App\FeatureCode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

use Symfony\Component\DomCrawler\Crawler;

class LoadFeatureCodes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $response =  Http::get($this->url());

        if ($response->failed()) {
            throw new FileNotDownloadedException($this->url());
        }

        $html = $response->body();
        $crawler = new Crawler($html);
     
        $rows = $crawler->filter('table.restable tr');

        $feature = null;
        foreach($rows as $row) {
            $rowEl = new Crawler($row);

            $content = $rowEl->children();

            if ($content->nodeName() === 'th') {
                $code = $content->filter('a')->attr('name');
                $description = $content->text();

                $feature = Feature::create([
                    'code' => $code,
                    'description' => ucfirst(trim(str_replace($code, '', $description)))
                ]);

                continue;
            }

            $featureCode = new FeatureCode();

            $content->each(function($item, $key) use (&$featureCode) {
                $value = $item->text();

                switch($key) {
                    case 0:
                        $featureCode->fill(['code' => $value]);
                        break;
                    case 1:
                        $featureCode->fill(['short_description' => ucfirst($value)]);
                        break;
                    case 2: 
                        $featureCode->fill(['full_description' => ucfirst($value)]);
                        break;
                };
            });

            $feature->featureCodes()->save($featureCode);
        }
    }

    /**
     * Get the url of the feature codes html page
     * 
     * @return string
     */
    private function url()
    {
        return config('geonames.feature_codes_url');
    }
}
