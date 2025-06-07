<?php

namespace App\Base;

use App\DTO\User\UserOrderByDTO;

class BaseService
{
    protected $resource;
    protected BaseDTO $filterDTO;
    protected array $_orderBy;

    public function __construct(){
        $this->filterDTO = new BaseDTO;
    }
    public function addFilter(BaseDTO $baseDTO):self{
        $this->filterDTO = $baseDTO;
        return $this;
    }

    public function setOrderBy(UserOrderByDTO $userOrderByDTO):self{
        $this->_orderBy = $userOrderByDTO->_orderBy;
        return $this;
    }
    public function getResource(){
        return $this->resource;
    }

    public function setResource($resource){
        $this->resource = $resource;
        return $this;
    }
}
