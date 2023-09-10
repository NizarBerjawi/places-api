<?php

namespace App\Pagination;

use Illuminate\Http\Resources\Json\PaginatedResourceResponse as IlluminateJsonPaginatedResourceResponse;
use Illuminate\Support\Arr;

class PaginatedResourceResponse extends IlluminateJsonPaginatedResourceResponse
{
    /**
     * Add the pagination information to the response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function paginationInformation($request)
    {
        $path = $request->url();
        $query = $request->query();
        $paginated = $this->resource->resource->toArray();
        $apiVersion = config('api.version');

        $next = $paginated['next_page_url'] ?? null;
        $prev = $paginated['prev_page_url'] ?? null;

        // We customize pagination links for people accessing Places API
        // through the RapidAPI proxy
        if ($request->hasHeader('X-RapidAPI-Host')) {
            $path = $request->getScheme().'://'.$request->header('X-RapidAPI-Host').'/'.str_replace("api/$apiVersion/", '', $request->path());

            if (isset($paginated['prev_cursor'])) {
                $query['page']['cursor'] = $paginated['prev_cursor'];

                $prev = $path.'?'.Arr::query($query);
            }

            if (isset($paginated['next_cursor'])) {
                $query['page']['cursor'] = $paginated['next_cursor'];

                $next = $path.'?'.Arr::query($query);
            }
        }

        return [
            'links' => [
                'prev' => $prev,
                'next' => $next,
            ],
            'meta' => [
                'nextCursor' => $paginated['next_cursor'] ?? null,
                'path' => $path,
                'perPage' => $paginated['per_page'] ?? null,
                'prevCursor' => $paginated['prev_cursor'] ?? null,
            ],
        ];
    }
}
