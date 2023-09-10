<?php

namespace App\Pagination;

use Illuminate\Http\Resources\Json\PaginatedResourceResponse as IlluminateJsonPaginatedResourceResponse;

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
        $paginated = $this->resource->resource->toArray();

        return [
            'links' => [
                'prev' => $paginated['prev_page_url'] ?? null,
                'next' => $paginated['next_page_url'] ?? null,
            ],
            'meta' => [
                'nextCursor' => $paginated['next_cursor'] ?? null,
                'path' => $request->url(),
                'perPage' => $paginated['per_page'] ?? null,
                'prevCursor' => $paginated['prev_cursor'] ?? null,
            ],
        ];
    }
}
