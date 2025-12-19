<?php

namespace App\Http\Resources\Company;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id"=>$this->resource->id,
            "name"=>$this->resource->name,
            "description"=>$this->resource->description,
            "avatar"=> $this->resource->avatar ? env("APP_URL")."storage/".$this->resource->avatar : null,
            // "avatar"=> $this->resource->avatar ? env("APP_URL").$this->resource->avatar : null,
            
            
            "users"=>$this->resource->user ? [
                "id"=>$this->resource->user->id,
                "full_name"=> $this->resource->user->name.' '.$this->resource->user->surname,
                ]:NULL,
                "eventos"=>$this->resource->evento ? [
                    "id"=>$this->resource->evento->id,
                    "name"=>$this->resource->evento->name,
                    ]:NULL,
                    
                    "created_at"=>$this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d h:i A") : NULL,
          

        ];
    }
}
