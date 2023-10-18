<?php

namespace App\Http\Resources\custorder;

use App\Models\Master\OrderModel;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerOrderCollection extends ResourceCollection
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
            'list' => $orderModel->customer($request->all()['customer'] ?? '', $request->all()['periode'] ?? '')
        ];
    }   
}
