<?php

namespace App\Models\Master;

use stdClass;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\RecordSignature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RekapPenjualanModel extends Model
{
    use RecordSignature;

    public function penjualan($customer = '', $tanggal = '', $menu = '')
    {
        $penjualan = DB::table('t_order')
                            ->join('t_detail_order as detail', 'detail.id_order', '=', 't_order.id_order')
                            ->join('m_item as m_item', 'm_item.id', '=', 'detail.id_item')
                            ->join('m_customer as m_customer', 'm_customer.id', '=', 't_order.id_user')
                            ->select([
                                DB::raw('m_customer.nama as nama_customer'),
                                DB::raw('m_item.nama as nama_item'),
                                DB::raw('total'),
                                DB::raw('jumlah'),
                                DB::raw('total_order'),
                                DB::raw('total_bayar'),
                                DB::raw('no_struk'),
                                DB::raw('potongan'),
                                DB::raw('diskon'),
                                DB::raw('DATE(tanggal) as tanggal'),
                            ]);
                            
        if (!empty($tanggal)) {
            $penjualan->where('tanggal', 'LIKE', '%'.$tanggal.'%');
        }        

        if (!empty($customer)) {
            $penjualan->where('m_customer.nama', 'LIKE', '%'.$customer.'%');
        } 

        if (!empty($menu)) {
            $penjualan->where('m_item.nama', 'LIKE', '%'.$menu.'%');
        } 

        $penjualan = $penjualan->get();

        $rekap = [];
        foreach ($penjualan as $data){
            $i = 0;
            if ( array_key_exists($data->no_struk, $rekap) ) {
                $order = new stdClass;
                $order->nama_item = $data->nama_item;
                $order->jumlah = $data->jumlah;
                $order->harga = $data->total;
                $order->total = ($data->total * $data->jumlah);

                $rekap[$data->no_struk]->order[] = $order;
            } else {
                $order = new stdClass;
                $order->nama_item = $data->nama_item;
                $order->jumlah = $data->jumlah;
                $order->harga = $data->total;
                $order->total = ($data->total * $data->jumlah);

                $obj = new stdClass;
                $obj->no_struk = $data->no_struk;
                $obj->tanggal = $data->tanggal;
                $obj->nama_customer = $data->nama_customer;
                $obj->total_order = $data->total_order;
                $obj->total_bayar = $data->total_bayar;
                $obj->potongan = $data->potongan;
                $obj->diskon = $data->diskon;
                $obj->order[] = $order;
                
                
                
                $rekap[$data->no_struk] = $obj;
            }
        }

        $res = [];
        foreach ($rekap as $data) {
            $res[] = $data;
        }
        
        return $res;
        // return $merged;
        // dd($merged);
    }
}
