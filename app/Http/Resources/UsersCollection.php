<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\UsersResource;

class UsersCollection extends ResourceCollection
{

    private $pagination;

    public function __construct($resource)
    {
        $this->pagination = [
            'total' => $resource->total(),
            'count' => $resource->count(),
            'per_page' => $resource->perPage(),
            'current_page' => $resource->currentPage(),
            'start' => (($resource->currentPage()-1)*$resource->perPage())+1,
            'to' => (($resource->currentPage()-1)*$resource->perPage())+$resource->count(),
            'total_pages' => $resource->lastPage(),
            'links' => [    'next' => $resource->nextPageUrl() ,
                            'prev' => $resource->previousPageUrl()
            ]
        ];

        $resource = $resource->getCollection();

        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge([
                'pagination' => $this->pagination
        ], (UsersResource::collection($this->collection))->toArray($request));
        ;
    }

}