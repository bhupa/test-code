<?php 

namespace App\Traits;


trait PaginationTrait {


    public function paginate($resource){

        return [
            'total'=>$resource->total(),
            'count'=>$resource->count(),
            'per_page'=>$resource->perPage(),
            'current_page'=>$resource->currentPage(),
            'last_page'=>$resource->lastPage(),
            'from'=>$resource->firstItem(),
            'to'=>$resource->lastItem(),
            'first_page_url'=>$resource->url(1),
            'next_page_url'=>$resource->nextPageUrl(),
            'prev_page_url'=>$resource->previousPageUrl(),
            'last_page_url'=>$resource->url($resource->lastPage()),
        ];
    }
}