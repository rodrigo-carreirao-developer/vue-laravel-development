<?php

namespace App\Repositories\User;
use App\Base\BaseRepository;
use App\Models\Base\BaseModel;
use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct()
    {
        $this->getModel();
    }
    public function getModel(): BaseModel
    {
        return $this->model = new User();
    }
    public function setModel(BaseModel $model): self
    {
        $this->model = $model;
        return $this;
    }

}
