<?php

namespace App\Http\Resources\Voucher;

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
            'id_customer'=> $this ->customer->id,
            'id_promo'=> [
                'id'=> $this->promo->id,
                'nominalUpdate'=>$this->promo->nominal,
            ],
            'jumlah'=> $this ->jumlah,  
            'jumlah_nominal'=> $this ->promo->nominal,
            'tanggal_mulai'=> $this ->tanggal_mulai,
            'periode_selesai'=> $this ->periode_selesai,
            'catatan'=> $this ->catatan,    
            'nama_customer'=> $this ->customer->nama,
            'nama_promo'=> $this ->promo->nama,
        ];
        }
}