<?php

namespace App\Http\Controllers\Api\Master;

use App\Helpers\Venturo;
use Illuminate\Http\Request;
use App\Helpers\User\UserHelper;
use App\Exports\Customer\MenuExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Master\LaporanMenuModel;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\order\OrderCollection;

class LaporanMenuController extends Controller
{
    private $order;

    public function __construct()
    {
        $this->order = new LaporanMenuModel();
    }

    // public function export()
    // {
    // //    return Excel::download(new MeuExport, 'users.xlsx');
    // }

    // public function index(Request $request)
    // {
    //     $filter = [
    //         'nama' => $request->nama ?? '',
    //         'email' => $request->email ?? '',
    //     ];
    //     $orders = $this->order->getAll($filter, $request->itemperpage ?? 0, $request->sort ?? '');


    //     return response()->success(new OrderCollection($orders));
    // }

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

    public function export(Request $request)
    {
        $filter = [
            'periode' => $request->periode ?? '',
            'kategori' => $request->kategori ?? '',
            'nama' => $request->nama ?? '',

        ];

        return Excel::download(new MenuExport($filter['kategori'], $filter['periode']), 'laporan.xlsx');
        // return view('export.penjualancustomer');
    }

        public function pdf(Request $request)
        {
            $filter = [
                'periode' => $request->periode ?? '',
                'kategori' => $request->kategori ?? '',
                'nama' => $request->nama ?? '',
                
            ];
            
            $day = array();
            for ($a=0; $a < 31; $a++) {
                $day [] = $a+1;
            }
            
            $listOrder = $this->order->menu($filter['kategori'] ,$filter['periode']);
            $listfood = $this->order->kategori('food',$filter );
            $listdrink = $this->order->kategori('drink', $filter );
            $listsnack = $this->order->kategori('snack', $filter );

            $data = [
                'day' => $day,
                // 'menu' => $menu,
                'listOrder' => $listOrder,
                'listfood' => $listfood,
                'listdrink' => $listdrink,
                'listsnack' => $listsnack,
                'kategori'=> ""
            ];

            $data = json_decode(json_encode($data), true);
            // dd($data);
            return Venturo::print('pdf.penjualanmenu', $data);
        }
}
