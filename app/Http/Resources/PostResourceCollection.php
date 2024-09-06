<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class PostResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->resource instanceof LengthAwarePaginator) {
            return [
                'data' => $this->collection,
                'current_page' => $this->currentPage(),
                'first_page_url' => $this->url(1),
                'from' => $this->firstItem(),
                'last_page' => $this->lastPage(),
                'last_page_url' => $this->url($this->lastPage()),
                'next_page_url' => $this->nextPageUrl(),
                'path' => $this->path(),
                'per_page' => $this->perPage(),
                'prev_page_url' => $this->previousPageUrl(),
                'to' => $this->lastItem(),
                'total' => $this->total(),
                'links' => [
                    [
                        'url' => $this->previousPageUrl(),
                        'label' => '&laquo; Previous',
                        'active' => $this->currentPage() === 1,
                    ],
                    [
                        'url' => $this->url($this->currentPage()),
                        'label' => (string) $this->currentPage(),
                        'active' => true,
                    ],
                    [
                        'url' => $this->nextPageUrl(),
                        'label' => 'Next &raquo;',
                        'active' => $this->currentPage() === $this->lastPage(),
                    ],
                ],
            ];
        }

        return [
            'data' => $this->collection,
        ];
    }
}
