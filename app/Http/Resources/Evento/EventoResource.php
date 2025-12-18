<?php

namespace App\Http\Resources\Evento;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class EventoResource extends JsonResource
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
            "precio_general"=>$this->resource->precio_general,
            "precio_estudiante"=>$this->resource->precio_estudiante,
            "precio_especialista"=>$this->resource->precio_especialista,
            "company"=>$this->resource->company,
            "companies"=>$this->resource->companies,
            "avatar"=> $this->resource->avatar ? env("APP_URL")."storage/".$this->resource->avatar : null,
            // "avatar"=> $this->resource->avatar ? env("APP_URL").$this->resource->avatar : null,
            
            "fecha_inicio"=>$this->resource->fecha_inicio ? Carbon::parse($this->resource->fecha_inicio)->format("Y/m/d") : NULL,
            "fecha_fin"=>$this->resource->fecha_fin ? Carbon::parse($this->resource->fecha_inicio)->format("Y/m/d") : NULL,
            
            "created_at"=>$this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d h:i A") : NULL,
            
            "clientes"=>$this->resource->cliente ? [
                "id"=>$this->resource->cliente->id,
                "roles"=>$this->resource->roles->first(),
            ]:NULL,
            "payments"=>$this->resource->payment ? [
                "id"=>$this->resource->payment->id,
            ]:NULL,

            // "clientes"=>$this->resource->clientes,

        ];
    }
}
