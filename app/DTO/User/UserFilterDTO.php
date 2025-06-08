<?php 
namespace App\DTO\User;

use App\Base\BaseDTO;
use Illuminate\Support\Arr;

class UserFilterDTO  extends BaseDTO
{

    public readonly string $search;
    public function __construct(array $_data)
    {
        $this->search = Arr::get($_data, 'search', '');
    }

}