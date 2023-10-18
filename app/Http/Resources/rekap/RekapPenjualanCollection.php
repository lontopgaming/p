<?php

namespace App\Http\Resources\rekap;

use App\Models\Master\OrderModel;
use App\Models\Master\RekapPenjualanModel;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RekapPenjualanCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
            $orderModel = new RekapPenjualanModel();
        return [
            'list' => $orderModel->penjualan($request->all()['customer'] ?? '', $request->all()['tanggal'] ?? '',  $request->all()['menu'] ?? '')
        ];
    }   
}
