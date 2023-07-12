<?php

namespace App\Http\Controllers;

use App\Models\FeatureClass;
use App\Queries\ContinentQuery;
use App\Queries\CountryQuery;
use App\Queries\FeatureCodeQuery;
use App\Queries\LanguageQuery;
use App\Queries\TimeZoneQuery;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class WebController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function docs()
    {
        return view('docs');
    }

    public function intro()
    {
        return view('intro');
    }

    public function flags($flag)
    {
        $filesystem = new Filesystem();

        $filepath = storage_path("app/flags/$flag");

        if ($filesystem->missing($filepath)) {
            abort(404);
        }

        return new BinaryFileResponse($filepath, 200);
    }

    public function continents(ContinentQuery $query)
    {
        return view('additionalResources.continents', [
            'continents' => $query->getPaginator(),
        ]);
    }

    public function countries(CountryQuery $query)
    {
        return view('additionalResources.countries', [
            'countries' => $query->getPaginator(),
        ]);
    }

    public function timeZones(TimeZoneQuery $query)
    {
        return view('additionalResources.timeZones', [
            'timeZones' => $query->getPaginator(),
        ]);
    }

    public function languages(LanguageQuery $query)
    {
        return view('additionalResources.languages', [
            'languages' => $query->getPaginator(),
        ]);
    }

    public function featureCodes(FeatureCodeQuery $query)
    {
        return view('additionalResources.featureCodes', [
            'featureCodes' => $query->getPaginator(),
            'featureClasses' => FeatureClass::get(),
            'selectedFeatureClass' => FeatureClass::query()
                ->where('code', Arr::get(request()->get('filter'), 'featureClassCode'))
                ->first(),
        ]);
    }
}
