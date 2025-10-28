<?php

namespace App\Http\Resources\Slider;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
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
            "id" =>$this->resource->id,
            "user_id" =>$this->resource->user_id,
            'title' =>$this->resource->title,
            'description' =>$this->resource->description,
            'is_activeText' =>$this->resource->is_activeText,
            'is_activeBot' =>$this->resource->is_activeBot,
            'boton' =>$this->resource->boton,
            'enlace' =>$this->resource->enlace,
            'target' =>$this->resource->target,
            'is_active' =>$this->resource->is_active,
            "avatar"=> $this->resource->avatar ? env("APP_URL")."storage/".$this->resource->avatar : null,
            // "avatar"=> $this->resource->avatar ? env("APP_URL").$this->resource->avatar : null,
            "imagemovil"=> $this->resource->imagemovil ? env("APP_URL")."storage/".$this->resource->imagemovil : null,
            // "imagemovil"=> $this->resource->imagemovil ? env("APP_URL").$this->resource->imagemovil : null,
            "created_at"=>$this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d h:i A") : NULL,
        ];
    }
}
