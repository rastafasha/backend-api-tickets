<?php

namespace App\Http\Resources\Evento;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EventoCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "data"=> EventoResource::collection($this->collection)
        ];
    }
}
