<?php

namespace App\Http\Resources\Promo;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailResource extends JsonResource
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
            'foto' => '',
            'fotoUrl' => $this->fotoUrl(),
            'nama' => $this->nama,
            'type' => $this->type,
            'syarat_ketentuan' => $this->syarat_ketentuan,
            'diskon' => $this->diskon,
            'nominal' => $this->nominal,
            'kadaluarsa' => $this->kadaluarsa,
        ];
    }
}
