<?php

namespace App\Http\Resources\voucher;

use Illuminate\Http\Resources\Json\JsonResource;

class VoucherResource extends JsonResource
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
            'id_customer' => $this->customer->id,
            'id_promo' => $this->promo->id,
            'nama_customer' => $this->customer->nama,
            'nama_promo' => $this->promo->nama,
            'jumlah' => $this->jumlah,
            'jumlah_nominal' => $this->jumlah_nominal,
            'tanggal_mulai' => $this->tanggal_mulai,
            'periode_selesai' => $this->periode_selesai,
            'catatan' => $this->catatan,
            
        ];
    }
}
