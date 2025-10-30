<?php

namespace App\Http\Resources\User;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
       

        return [
            "id"=>$this->resource->id,
            "name"=>$this->resource->name,
            "surname"=>$this->resource->surname,
            "full_name"=> $this->resource->name.' '.$this->resource->surname,
            "email"=>$this->resource->email,
            // "password"=>$this->resource->password,
            "n_doc"=>$this->resource->n_doc,
            "mobile"=>$this->resource->mobile,
            "telefono"=>$this->resource->telefono,
            "address"=>$this->resource->address,
            "birth_date"=>$this->resource->birth_date,
            "gender"=>$this->resource->gender,
            "status"=>$this->resource->status,
            "empresa"=>$this->resource->empresa,
            "avatar"=> $this->resource->avatar ? env("APP_URL")."storage/".$this->resource->avatar : null,
            // "avatar"=> $this->resource->avatar ? env("APP_URL").$this->resource->avatar : null,
            
            "eventos"=>$this->resource->eventos,
            "roles"=>$this->resource->roles->first(),
            "created_at"=>$this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y/m/d") : NULL,
            
        ];
    }
}
