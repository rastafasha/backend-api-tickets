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
            "metodo_id" => $this->resource->metodo_id,
            "metodo" => $this->resource->metodo ?
                [
                    "id" => $this->resource->metodo->id,
                    "name" => $this->resource->metodo->name,
                    "tipo" => $this->resource->metodo->tipo,
                    "bankAccount" => $this->resource->metodo->bankAccount,
                    "bankName" => $this->resource->metodo->bankName,
                    "email" => $this->resource->metodo->email,
                    "user" => $this->resource->metodo->user,
                    "ciorif" => $this->resource->metodo->ciorif,
                    "telefono" => $this->resource->metodo->telefono,
                ] : NULL,
            "bank_name" => $this->resource->bank_name,
            "bank_destino" => $this->resource->bank_destino,
            "monto" => $this->resource->monto,
            "nombre" => $this->resource->nombre,
            "email" => $this->resource->email,

            "event_id" => $this->resource->event_id,
            "event" => $this->resource->event ?
                [
                    "id" => $this->resource->event->id,
                    "name" => $this->resource->event->name,
                    "description" => $this->resource->event->description,
                    "precio_general" => $this->resource->event->precio_general,
                    "precio_estudiantes" => $this->resource->event->precio_estudiantes,
                    "precio_especialistas" => $this->resource->event->precio_especialistas,
                    "fecha_inicio" => $this->resource->event->fecha_inicio ? Carbon::parse($this->resource->event->fecha_inicio)->format("Y/m/d") : NULL,
                    "fecha_fin" => $this->resource->event->fecha_fin ? Carbon::parse($this->resource->event->fecha_fin)->format("Y/m/d") : NULL,

                    // "avatar"=> $this->resource->client->avatar ? env("APP_URL")."storage/".$this->resource->client->avatar : null,
                    "avatar" => $this->resource->event->avatar ? env("APP_URL") . $this->resource->client->avatar : null,

                ] : NULL,
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
