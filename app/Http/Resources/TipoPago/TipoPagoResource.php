<?php

namespace App\Http\Resources\TipoPago;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TipoPagoResource extends JsonResource
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
            "id" => $this->resource->id,
            "name" => $this->resource->name,
            "tipo" => $this->resource->tipo,
            "bankAccount" => $this->resource->bankAccount,
            "bankName" => $this->resource->bankName,
            "email" => $this->resource->email,
            "user" => $this->resource->user,
            "ciorif" => $this->resource->ciorif,
            "telefono" => $this->resource->telefono,
            "status" => $this->resource->status,
            "company_id"=>$this->resource->company_id,
            "company"=>$this->resource->company ? [
                "id"=>$this->resource->company->id,
                "name"=>$this->resource->company->name,
            ]:NULL,

            "created_at" => $this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d h:i A") : NULL,
        ];
    }
}
