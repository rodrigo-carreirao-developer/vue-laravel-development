<?php

namespace App\Repositories\Concerns;

use App\Models\Base\BaseModel;
use DB;

trait ActionDelete
{
    public function deleteResource(BaseModel $resource)
    {
        $resource = DB::transaction(function () use ($resource) {
            $resource->delete();
            return $resource;
        });

        return $resource;
    }
}
