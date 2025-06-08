<?php

namespace App\Services\User;

use App\Base\BaseDTO;
use App\Base\BaseService;
use App\Repositories\User\UserRepository;

class UserService extends BaseService
{

    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository    = $userRepository;
        parent::__construct();
    }

    public function list(){
        return $this->userRepository
            ->addFilter($this->baseDTO)
            ->setOrderBy($this->_orderBy)
            ->list();
    }

    public function paginate($perPage=50){
        return $this->userRepository
            ->addFilter($this->filterDTO)
            ->setOrderBy($this->_orderBy)
            ->paginate($perPage);
    }

    public function store(array $attributes){
        $this->resource = $this->userRepository
            ->storeResource($attributes);
        return $this;
    }

    public function update(array $attributes){
        $this->resource = $this->userRepository
            ->updateResource($this->resource, $attributes);
        return $this;
    }

    public function delete(){
        $this->resource = $this->userRepository
            ->deleteResource($this->resource);
        return $this;
    }

}
