<?php

namespace App\Http\Controllers\Api\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Master\DashboardModel;
use App\Http\Resources\dashboard\DashboardCollection;

class DashboardController extends Controller
{
    private $dashboard;

    public function __construct(){
        $this->dashboard = new DashboardModel();
    }

    public function index(){
        $totalToday = $this->dashboard->getTotalToday();
        $totalYesterday = $this->dashboard->getTotalYesterday();
        $totalThisMonth = $this->dashboard->getTotalThisMonth();
        $totalLastMonth = $this->dashboard->getTotalLastMonth();

        $data = [
            'totalToday' => $totalToday,
            'totalYesterday' => $totalYesterday,
            'totalThisMonth' => $totalThisMonth,
            'totalLastMonth' => $totalLastMonth
        ];

        $data = json_decode(json_encode($data), true);

        return $data;
    }

    public function Chart(Request $request) {

        $filter = [
            'Awal' => $request->Awal,
            'Akhir' => $request->Akhir,
        ];

        $dataChart = $this->dashboard->Chart($filter['Awal'], $filter['Akhir']);

        return $dataChart;
    }
}
