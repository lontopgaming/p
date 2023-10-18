<?php

namespace App\Http\Controllers\Api\Master;

use App\Helpers\Venturo;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Master\OrderModel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Customer\CustomerExport;
use App\Models\Master\LaporanCustomerModel;
use App\Http\Resources\custorder\CustomerOrderCollection;

class LaporanCustomerController extends Controller
{
    private $order;

    public function __construct()
    {
        $this->order = new LaporanCustomerModel();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function customer(Request $request)
    {
        $filter = [
            'periode' => $request->periode ?? '',
            'customer' => $request->customer ?? '',
            'nama' => $request->nama ?? '',

        ];
        $listOrder = $this->order->customer($filter['customer'] ?? '', $filter['periode'] ?? '');
        return response()->success(new CustomerOrderCollection($listOrder));
    }

        
        
        public function export(Request $request) 
        {
            $filter = [
                'periode' => $request->periode ?? '',
                'customer' => $request->customer ?? '',
                'nama' => $request->nama ?? '',
    
            ];

            return Excel::download(new CustomerExport($filter['customer'], $filter['periode']), 'collection.xlsx');
            // return view('export.penjualancustomer');
        }


        public function pdf(Request $request){
            $filter = [
                'periode' => $request->periode ?? '',
                'customer' => $request->customer ?? '',
                'nama' => $request->nama ?? ''
    
            ];

            $day = array();
            for($a=0; $a < 31; $a++){
                $day [] = $a+1;
            }

            $listOrder = $this->order->customer($filter['customer'], $filter['periode'], $filter['nama']);
            $customer = $this->order->namacust();

            $data = [
                'day' => $day,
                'listOrder'=>$listOrder,
                'customer'=> $customer
            ];

            $data = json_decode(json_encode($data), true);
            // dd($data);
            return Venturo::print('pdf.penjualancustomer', $data);
        }
}


