<?php

namespace App\Http\Resources\order;

use App\Models\Master\OrderModel;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
            $orderModel = new OrderModel();
        return [
            'list' => $orderModel->menu($request->all()['kategori'] ?? '', $request->all()['periode'] ?? '')
        ];
    }   
}
