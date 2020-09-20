<?php

namespace App\Jobs;

use App\Exceptions\FileNotDownloadedException;
use App\Feature;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use Symfony\Component\DomCrawler\Crawler;

class LoadFeatures implements ShouldQueue
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
     
        $headers = $crawler->filter('table.restable tr th');

        foreach($headers as $header) {
            $headerElement = new Crawler($header);

            $code = $headerElement->filter('a')->attr('name');
            $description = $headerElement->text();

            $data = [
                'code' => $code,
                'description' => ucfirst(trim(str_replace($code, '', $description)))
            ];
            
            Feature::create($data);
        }
    }

    /**
     * Get the url of the feature classes html page
     * 
     * @return string
     */
    private function url()
    {
        return config('geonames.feature_codes');
    }
}
