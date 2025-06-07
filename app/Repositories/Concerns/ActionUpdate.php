<?php

namespace App\Repositories\Concerns;


use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

trait ActionUpdate
{
    /**
     * Update a resource
     *
     * @param BaseModel $resource
     * @param array $attributes
     *
     * @return  BaseModel
     */
    public function updateResource(BaseModel $resource, array $attributes): BaseModel
    {
        return DB::transaction(function () use ($resource, $attributes) {
            $resource->fill($attributes);
            $resource->save();
            $resource->refresh();
            return $resource;
        });
    }
}
