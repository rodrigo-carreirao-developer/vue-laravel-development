<?php

namespace App\Repositories\Concerns;

use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\DB;

trait ActionStore
{
    /**
     * Save resource
     * @param BaseModel $resource
     * @return  BaseModel
     */
    public function save(BaseModel $resource): BaseModel
    {
        $resource->save();
        return $resource;
    }

    /**
     * Store a resource
     * @param array $attributes
     * @return  BaseModel
     */
    public function storeResource(array $attributes): BaseModel
    {
        return DB::transaction(function () use ($attributes) {
            $resource = new $this->model;
            $resource = $resource->fill($attributes);
            $resource = $this->save($resource);
            $resource->refresh();
            return $resource;
        });
    }

    /**
     * Store a resource
     * @param array $attributes
     * @return  BaseModel
     */
    public function storeOrUpdateResource(array $conditional, array $attributes): BaseModel
    {
        return DB::transaction(function () use ($conditional, $attributes) {
            $resource = $this->model->where($conditional)->first();
            if(!$resource){
                $resource = new $this->model;
            }
            $resource = $resource->fill($attributes);
            $resource = $this->save($resource);
            $resource->refresh();
            return $resource;
        });
    }
}
