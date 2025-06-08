<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(!isset($this->id)){ return null; }
        
        $_data = [
                'id'                => $this->id,
                'name'              => $this->name,
                'email'             => $this->email,
                'created_at'        => $this->created_at,
                'updated_at'        => $this->updated_at
            ];

        return $_data;
    }

}