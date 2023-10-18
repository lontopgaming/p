<?php

namespace App\Http\Resources\diskon;

use Illuminate\Http\Resources\Json\JsonResource;

class DiskonResource extends JsonResource
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
            'id' => $this->id,
            'id_customer' => $this->id_customer,
            'id_promo' => $this->id_promo,
            'status' => $this->status,            
        ];;
    }
}
    