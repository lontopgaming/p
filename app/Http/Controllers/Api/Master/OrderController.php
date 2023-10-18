<?php

namespace App\Http\Controllers\Api\Report; 

use stdClass;
use Illuminate\Http\Request;
use App\Models\Master\OrderModel;
use Illuminate\Support\Facades\DB;
use App\Helpers\Report\OrderHelper;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\Report\ReportPenjualan;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Order\OrderCollection;
use App\Http\Resources\Order\OrderChartCollection;
use App\Http\Resources\Order\CustomerOrderCollection;
use App\Http\Resources\Order\PenjualanOrderCollection;

class OrderController extends Controller
{
    private $order;

    public function __construct()
    {
        $this->order = new OrderModel();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function menu(Request $request)
    {
        $filter = [
            'periode' => $request->periode ?? '',
            'kategori' => $request->kategori ?? '',
            'nama' => $request->nama ?? '',

        ];
        $listOrder = $this->order->menu($filter['kategori'] ?? '', $filter['periode'] ?? '');
        return response()->success(new OrderCollection($listOrder));
    }

    // public function chart(Request $request)
    // {
    //     $filter = [
    //         'periode' => $request->periode ?? '',
    //         'kategori' => $request->kategori ?? '',
    //         'nama' => $request->nama ?? '',
    //     ];
    //     $listOrder = $this->order->chart();
    //     return response()->success(new OrderChartCollection($listOrder));
    // }

    // public function customer(Request $request)
    // {
    //     $filter = [
    //         'periode' => $request->periode ?? '',
    //         'id_customer' => $request->id_customer ?? '',
    //         'nama' => $request->nama ?? '',

    //     ];
    //     $listOrder = $this->order->customer($filter['id_customer'] ?? '', $filter['periode'] ?? '');
    //     return response()->success(new CustomerOrderCollection($listOrder));
    // }

    // public function penjualan(Request $request)
    // {
    //     $filter = [
    //         'tanggal' => $request->tanggal ?? '',
    //         'id_customer' => $request->id_customer ?? '',
    //         'nama' => $request->nama ?? '',

    //     ];
    //     $listOrder = $this->order->penjualan($filter['nama'] ?? '', $filter['tanggal'] ?? '');
    //     return response()->success(new PenjualanOrderCollection($listOrder));
    // }

    // public function export_excel(){
    //     return Excel::download(new ReportPenjualan, 'laporan_penjualan.xlsx');
    // }
}