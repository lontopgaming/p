<?php

namespace App\Exports\Customer;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Master\LaporanMenuModel;

class MenuExport implements FromView
{
    protected $menu;
    protected $kategori;
    protected $periode;
    protected $filter;

    public function __construct($kategori, $periode)
    {
        $this->kategori = $kategori;
        $this->periode = $periode;
        $this->menu = new LaporanMenuModel();

        $this->filter =[
            'kategori'=> $this->kategori,
            'periode'=> $this->periode
        ];
    }
    
    public function view(): View
    {
        $listOrder = $this->menu->menu($this->kategori , $this->periode);
        // $menu = $this->menu->namamenu();
        $listfood = $this->menu->kategori('food', $this->filter );
        $listdrink = $this->menu->kategori('drink', $this->filter );
        $listsnack = $this->menu->kategori('snack', $this->filter );

        $day = array();
        for($a=0; $a < 31; $a++){
            $day [] = $a+1;
        }



        $data = [
            'day' => $day,
            // 'menu' => $menu,
            'listOrder' => $listOrder,
            
            'listfood' => $listfood,
            'listdrink' => $listdrink,
            'listsnack' => $listsnack,
            'kategori'=> $this->kategori
        ];

        $data = json_decode(json_encode($data), true);
        // dd($data);
        return view('export.penjualanmenu', compact('data'));
    }
}