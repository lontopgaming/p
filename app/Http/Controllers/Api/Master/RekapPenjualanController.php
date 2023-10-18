<?php

namespace App\Http\Controllers\Api\Master;

use App\Helpers\Venturo;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Customer\RekapExport;
use App\Models\Master\RekapPenjualanModel;
use App\Http\Resources\rekap\RekapPenjualanCollection;

class RekapPenjualanController extends Controller
{
    private $order;

    public function __construct()
    {
        $this->order = new RekapPenjualanModel();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function penjualan(Request $request)
    {
        $filter = [
            'periode' => $request->periode ?? '',
            'kategori' => $request->kategori ?? '',
            'nama' => $request->nama ?? '',

        ];
        $listOrder = $this->order->penjualan($filter['nama'] ?? '', $filter['periode'] ?? '', $filter['menu'] ?? '');
        return response()->success(new RekapPenjualanCollection($listOrder));
    }

    public function export(Request $request) 
    {
        $filter = [
            'periode' => $request->periode ?? '',
            'customer' => $request->customer ?? '',
            'menu' => $request->menu ?? ''

        ];

        $data = $this->order->penjualan($filter['customer'], $filter['periode'], $filter['menu']);
        // dd($data);
        return Venturo::print('pdf.rekappenjualan', $data);
    
    }

    public function excel(Request $request){
        $filter = [
            'tanggal' => $request->tanggal ?? '',
            'customer' => $request->customer ?? '',
            'menu' => $request->menu ?? '',

        ];

        return Excel::download(new RekapExport($filter['customer'], $filter['tanggal'], $filter['menu']), 'rekappenjualan.xlsx');
        // return view('export.penjualancustomer');
    }
}
