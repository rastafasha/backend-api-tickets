<?php

namespace App\Http\Resources\TipoPago;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TipoPagoCollection extends ResourceCollection
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
            "data"=> TipoPagoResource::collection($this->collection)
        ];
    }
}
