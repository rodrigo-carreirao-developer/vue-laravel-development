<?php

namespace App\Base;
use App\Repositories\Concerns\ActionDelete;
use App\Repositories\Concerns\ActionList;
use App\Repositories\Concerns\ActionStore;
use App\Repositories\Concerns\ActionUpdate;
use App\Models\Base\BaseModel;


abstract class BaseRepository
{
    use ActionList, ActionDelete, ActionStore, ActionUpdate;

    protected BaseModel $model;

    abstract public function getModel(): BaseModel;
    abstract public function setModel(BaseModel $model): self;
}
