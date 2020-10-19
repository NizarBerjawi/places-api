<?php

namespace App\Imports;

use App\Country;
use App\Language;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;

class NeighbourCountriesImport implements OnEachRow
{
    /**
     * @param array $row
     *
     * @return Language|null
     */
    public function onRow(Row $row)
    {
        $row = $row->toArray();

        if (Str::startsWith($row[0], '#')) {
            return;
        }

        $neighbours = Str::of($row[17])->trim();
        
        if ($neighbours->isEmpty()) {
            return;
        }

        $country = Country::query()
            ->where('iso3166_alpha2', $row[0])
            ->first();

        if (!$country) {
            return;
        }

        $neighbours->explode(',')
            ->each(function ($code) use ($country) {
                $neighbour = Country::query()
                    ->where('iso3166_alpha2', $code)
                    ->first();
                
                if (!$neighbour) {
                    return;
                }
                
                $country->neighbours()->attach($neighbour);
            });
    }
}
