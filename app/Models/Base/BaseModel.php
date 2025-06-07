<?php

namespace App\Models\Base;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $databaseDriver = null;

    /**
     * Created this method to be a fast way to retrieve LIKE statement from different databases as pgsql.
     */
    protected function retrieveLikeStatement():string{
        $connection = config('database.default');
        $this->databaseDriver = config("database.connections.{$connection}.driver");
        if($this->databaseDriver == 'pgsql'){
            return "ILIKE";
        }
        return "LIKE";
    }
}