<?php

namespace App\Pagination;

use Illuminate\Http\Resources\Json\PaginatedResourceResponse as IlluminateJsonPaginatedResourceResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PaginatedResourceResponse extends IlluminateJsonPaginatedResourceResponse
{
    /**
     * Gather the meta data for the response.
     *
     * @param  array  $paginated
     * @return array
     */
    protected function meta($paginated)
    {
        return collect(Arr::except($paginated, [
            'data',
            'first_page_url',
            'last_page_url',
            'prev_page_url',
            'next_page_url',
        ]))->flatMap(function ($value, $key) {
            return [
                Str::camel($key) => $value,
            ];
        });
    }
}
