<?php

namespace App\Repositories\Concerns;

use App\Base\BaseDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

trait ActionList
{
    protected $_with = [];
    protected $_filter = [];
    protected $_orderBy = [];
    public function addFilter(BaseDTO $baseDTO):self{
        $this->_filter = $baseDTO->toArray();
        return $this;
    }

    public function setOrderBy(array $_orderBy):self{
        $this->_orderBy = $_orderBy;
        return $this;
    }

    public function onBeforeList(Builder &$query):self{
        if($this->_filter){
            foreach($this->_filter as $key => $value){
                if($value != ""){
                    // Could be in a middleware!
                    $method = str_replace(' ', '', lcfirst(ucwords(str_replace('_', ' ',str_replace('-', ' ', $key)))));
                    $query->$method($value);
                }
            }
        }
        if(count($this->_orderBy)){
            $this->parseOrderBy($query);
        }
        return $this;
    }
    public function list(): Collection
    {
        $query = $this->model->with($this->_with);
        $this->onBeforeList($query);
        return $query->get();
    }

    public function paginate($perPage=50): LengthAwarePaginator
    {
        $query = $this->model->with($this->_with);
        $this->onBeforeList($query);
        return $query->paginate($perPage);
    }

    public function addRelationWith($relation){
        $this->_with[] = $relation;
        return $this;
    }

    private function parseOrderBy(Builder $query):self{
        foreach($this->_orderBy as $key => $_order){
            foreach($_order as $key => $order){
                if($this->model->isFillable($order)){
                    $query = $query->orderBy($order, $key ?? "ASC");
                }
            }
            
        }
        return $this;
    }
}
