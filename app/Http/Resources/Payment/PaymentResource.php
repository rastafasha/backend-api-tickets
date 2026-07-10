<?php

namespace App\Http\Resources\Payment;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PaymentResource extends JsonResource
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
            "referencia" => $this->resource->referencia,
            "metodo" => $this->resource->metodo,
            "bank_name" => $this->resource->bank_name,
            "bank_destino" => $this->resource->bank_destino,
            "monto" => $this->resource->monto,
            "nombre" => $this->resource->nombre,
            "email" => $this->resource->email,
            "parent_id" => $this->resource->parent_id,
            "client_id" => $this->resource->client_id,
            "client" => $this->resource->client ?
                [
                    "id" => $this->resource->client->id,
                    "email" => $this->resource->client->email,
                    "full_name" => $this->resource->client->name . ' ' . $this->resource->client->surname,
                    "name" => $this->resource->client->name,
                    "surname" => $this->resource->client->surname,
                    // "password"=>$this->resource->password,
                    "n_doc" => $this->resource->client->n_doc,
                    "mobile" => $this->resource->client->mobile,
                    "telefono" => $this->resource->client->telefono,
                    "address" => $this->resource->client->address,
                    "birth_date" => $this->resource->client->birth_date,
                    "gender" => $this->resource->client->gender,
                    "status" => $this->resource->client->status,
                    "pais_id" => $this->resource->client->pais_id,
                    "pais" => $this->resource->client->pais ? [
                        "id" => $this->resource->client->pais->id,
                        "title" => $this->resource->client->pais->title,
                        "code" => $this->resource->client->pais->code,
                    ] : NULL,
                    // "avatar"=> $this->resource->client->avatar ? env("APP_URL")."storage/".$this->resource->client->avatar : null,
                    "avatar" => $this->resource->client->avatar ? env("APP_URL") . $this->resource->client->avatar : null,

                ] : NULL,

            "status" => $this->resource->status,
            "fecha" => $this->resource->fecha,
            "avatar" => $this->resource->avatar ? url(Storage::url($this->resource->avatar)) : null,
            // "avatar" => $this->resource->avatar ? env("APP_URL") . "storage/" . $this->resource->avatar : null,
            // "avatar"=> $this->resource->avatar ? env("APP_URL").$this->resource->avatar : null,

            "created_at" => $this->resource->created_at ? Carbon::parse($this->resource->created_at)->format("Y-m-d h:i A") : NULL,
        ];
    }
}
