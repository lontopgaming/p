<?php

namespace App\Http\Resources\dashboard;

use App\Models\Master\OrderModel;
use App\Models\Master\DashboardModel;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DashboardCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
            $data = new DashboardModel();
        return [
            'list' => $data->index($request->all()['customer'] ?? '', $request->all()['tanggal'] ?? '')
        ];
    }   
}
