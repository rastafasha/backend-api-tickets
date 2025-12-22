<?php

namespace App\Http\Resources\Ticket;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
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
            "event_name"=>$this->resource->event_name,
            "referencia"=>$this->resource->referencia,
            "monto"=>$this->resource->monto,
            "status"=>$this->resource->status,
            "qr_code"=>$this->resource->qr_code,
            "from_id"=>$this->resource->from_id || NULL,
            "from"=>$this->resource->from ? [
                "id"=>$this->resource->from->id,
                "name"=>$this->resource->from->name,
            ]:NULL,
            "client_id"=>$this->resource->client_id || NULL,
            "client"=>$this->resource->client ? [
                "id"=>$this->resource->client->id,
                "name"=>$this->resource->client->name,
                "email"=>$this->resource->client->email,
            ]:NULL,
            "company_id"=>$this->resource->company_id || NULL,
            "company"=>$this->resource->company ? [
                "id"=>$this->resource->company->id,
                "name"=>$this->resource->company->name,
            ]:NULL,
            "event_id"=>$this->resource->event_id || NULL,
            "event"=>$this->resource->event ? [
                "id"=>$this->resource->event->id,
                "name"=>$this->resource->event->name,
                "event_name"=>$this->resource->event->name,
            ]:NULL,
            
            "fecha_inicio"=>$this->resource->fecha_inicio ? Carbon::parse($this->resource->fecha_inicio)->format("Y/m/d") : NULL,
            "fecha_fin"=>$this->resource->fecha_fin ? Carbon::parse($this->resource->fecha_fin)->format("Y/m/d") : NULL,
            
            "created_at"=>$this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d h:i A") : NULL,
            "updated_at"=>$this->resource->updated_at ? Carbon::parse($this->resource->updated_at)->format("Y-m-d h:i A") : NULL,
        ];
    }
}
