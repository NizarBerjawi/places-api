<?php

namespace App\Imports;

use App\Language;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class LanguagesImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return Language|null
     */
    public function model(array $row)
    {
        if (Str::startsWith($row[0], '#')) {
            return;
        }
        return new Language([
            'iso639_1' => $row[2],
            'iso639_2' => $row[1],
            'iso639_3' => $row[0],
            'language_name' => $row[3],
        ]);
    }

    /**
     * The row to start importing from
     *
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
}
