<?php 
namespace App\DTO\User;

use App\Base\BaseDTO;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class UserFilterDTO  extends BaseDTO
{

    public readonly string $search;
    public readonly string $name;
    public readonly string $email;
    public readonly string $createdAt;
    public function __construct(array $_data)
    {
        $this->search = Arr::get($_data, 'search', '');
        $this->name = Arr::get($_data, 'name', '');
        $this->email = Arr::get($_data, 'email', '');
        $this->parseCreatedAt($_data);
    }

    public function parseCreatedAt(array $_data){
        $createdAt = Arr::get($_data, 'created_at', '');
        if($createdAt != '' && preg_match("$/$", $createdAt)){
            $createdAt = Carbon::createFromFormat("d/m/Y", $createdAt)->format("Y-m-d");
        }
        $this->created_at = $createdAt;
    }

}