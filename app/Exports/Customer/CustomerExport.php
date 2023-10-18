<?php

namespace App\Exports\Customer;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Master\LaporanCustomerModel;

class CustomerExport implements FromView
{
    protected $cust;
    protected $customer;
    protected $periode;
        
    


    public function __construct($customer, $periode)
    {
        $this->customer = $customer;
        $this->periode = $periode;
        $this->cust = new LaporanCustomerModel();

    }
    
    public function view(): View
    {
        $listOrder = $this->cust->customer($this->customer , $this->periode);
        $customer = $this->cust->namacust();

        $day = array();
        for($a=0; $a < 31; $a++){
            $day [] = $a+1;
        }

        $data = [
            'day' => $day,
            'customer' => $customer,
            'listOrder' => $listOrder
        ];

        $data = json_decode(json_encode($data), true);
        // dd($data);
        return view('export.penjualancustomer', compact('data'));
    }
}