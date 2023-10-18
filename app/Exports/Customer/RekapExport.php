<?php

namespace App\Exports\Customer;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Master\RekapPenjualanModel;
use App\Models\Master\LaporanCustomerModel;

class RekapExport implements FromView
{
    protected $rekap;
    protected $customer;
    protected $tanggal;
    protected $menu;
        
    


    public function __construct($customer, $tanggal, $menu)
    {
        $this->customer = $customer;
        $this->tanggal = $tanggal;
        $this->menu = $menu;
        $this->rekap = new RekapPenjualanModel();
    }
    
    public function view(): View
    {
        $data =  $this->rekap->penjualan($this->customer , $this->tanggal, $this->menu);

        $data = json_decode(json_encode($data), true);
        // dd($data);
        return view('export.rekappenjualan', compact('data'));
    }
}