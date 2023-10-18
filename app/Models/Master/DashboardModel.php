<?php

namespace App\Models\Master;

use stdClass;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\RecordSignature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DashboardModel extends Model
{
    use RecordSignature;

   public function getTotalToday() {
        $totalToday = DB::table('t_order')
                        ->join('t_detail_order', 't_detail_order.id_order', '=', 't_order.id_order')
                        ->select(DB::raw('SUM(t_detail_order.total) as total'))
                        ->where(
                            't_order.tanggal', '=', DB::raw('CURRENT_DATE()')
                        );
        $totalToday = $totalToday->get();
        
        return $totalToday;
    }

    public function getTotalYesterday() {
        $totalYesterday = DB::table('t_order')
                            ->join('t_detail_order', 't_detail_order.id_order', '=', 't_order.id_order')
                            ->select(DB::raw('SUM(t_detail_order.total) as total'))
                            ->where(
                                't_order.tanggal', '=', DB::raw('SUBDATE(CURRENT_DATE(), 1)')
                            )->get();

        return $totalYesterday;
    }

    public function getTotalThisMonth() {
        $totalThisMonth = DB::table('t_order')
                            ->join('t_detail_order', 't_detail_order.id_order', '=', 't_order.id_order')
                            ->select(DB::raw('SUM(t_detail_order.total) as total'))
                            ->whereMonth('t_order.tanggal', '=', DB::raw('MONTH(CURRENT_DATE)'))
                            ->whereYear('t_order.tanggal', '=', DB::raw('YEAR(CURRENT_DATE)'))->get();

        return $totalThisMonth;
    }

    public function getTotalLastMonth() {
        $totalLastMonth = DB::table('t_order')
                            ->join('t_detail_order', 't_detail_order.id_order', '=', 't_order.id_order')
                            ->select(DB::raw('SUM(t_detail_order.total) as total'))
                            ->whereMonth('t_order.tanggal', '=', DB::raw('MONTH(CURRENT_DATE) - 1'))
                            ->whereYear('t_order.tanggal', '=', DB::raw('YEAR(CURRENT_DATE)'))->get();

        return $totalLastMonth;
    }

    public function Chart($Awal, $Akhir) {
        $dataChart = DB::table('t_order')
                            ->join('t_detail_order', 't_detail_order.id_order', '=', 't_order.id_order')
                            ->select([
                                DB::raw('MONTHNAME(t_order.tanggal) as nama_bulan'),
                                DB::raw('MONTH(t_order.tanggal) as bulan'),
                                DB::raw('YEAR(t_order.tanggal) as tahun'),
                                DB::raw('SUM(t_detail_order.total) as totalPerBulan')
                            ])
                            ->groupBy(DB::raw('MONTH(t_order.tanggal)'), 't_order.tanggal')
                            ->orderBy(DB::raw('YEAR(t_order.tanggal)'), 'ASC')
                            ->orderBy(DB::raw('MONTH(t_order.tanggal)'), 'ASC');


        if (!empty($Awal) && !empty($Akhir)) {
            $dataChart->whereBetween(DB::raw('t_order.tanggal'), [$Awal, $Akhir]);
        }

        $dataChart = $dataChart->get();

        return $dataChart;

    }
}

