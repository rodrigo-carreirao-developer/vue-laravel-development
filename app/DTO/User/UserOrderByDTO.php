<?php 
namespace App\DTO\User;

use App\Base\BaseDTO;
use Illuminate\Support\Arr;

class UserOrderByDTO  extends BaseDTO
{

    public readonly array $_orderBy;
    public function __construct(array $_data)
    {
        $_orderBy = Arr::get($_data, 'orderBy', []);
        if(is_array($_orderBy)){
            $this->_orderBy = $_orderBy;
        }
    }
}