<?php

namespace App\Models\Master;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanMenuModel extends Model
{
    use HasFactory;

    public static function menu($kategori = null, $periode = ''){
        $totalTanggalMenu = DB::table('t_order')
                ->join('t_detail_order', 't_detail_order.id_order', '=', 't_order.id_order')
                ->join('m_item', 'm_item.id', '=', 't_detail_order.id_item')
                ->select([
                    DB::raw('sum(total) as total'),
                    DB::raw('DATE(tanggal) as tanggal'),
                    DB::raw('id_item as id_menu'),
                    DB::raw('nama as nama_menu'),
                ])->groupBy('tanggal', 'id_item', 'nama');

        if (!empty($periode)) {
            $totalTanggalMenu->where('tanggal', 'LIKE', '%'.$periode.'%');
        }        

        if (!empty($kategori)) {
            $totalTanggalMenu->where('kategori', $kategori);
        } 
        
        $totalMenu = DB::table('t_order')
                ->join('t_detail_order', 't_detail_order.id_order', '=', 't_order.id_order')
                ->join('m_item', 'm_item.id', '=', 't_detail_order.id_item')
                ->select([
                    DB::raw('sum(total) as total'),
                    DB::raw('id_item as id_menu'),
                    DB::raw('nama as nama_menu'),
                ])->groupBy('id_item', 'nama');

        if (!empty($kategori)) {
            $totalMenu->where('kategori', $kategori);
        }     
        
        if (!empty($periode)) {
            $totalMenu->where('tanggal', 'LIKE', '%'.$periode.'%');
        } 

        $totalTanggal = DB::table('t_order')
                ->join('t_detail_order', 't_detail_order.id_order', '=', 't_order.id_order')
                ->join('m_item', 'm_item.id', '=', 't_detail_order.id_item')
                ->select([
                    DB::raw('sum(total) as total'),
                    DB::raw('DATE(tanggal) as tanggal')
                ])->groupBy('tanggal');

        if (!empty($kategori)) {
            $totalTanggal->where('kategori', $kategori);
        }        

        if (!empty($periode)) {
            $totalTanggal->where('tanggal', 'LIKE', '%'.$periode.'%');
        } 
        
        $totalKategori = DB::table('t_order')
                ->join('t_detail_order', 't_detail_order.id_order', '=', 't_order.id_order')
                ->join('m_item', 'm_item.id', '=', 't_detail_order.id_item')
                ->select([
                    DB::raw('sum(total) as total'),
                    DB::raw('kategori as kategori'),
                ])->groupBy('kategori');

        if (!empty($kategori)) {
            $totalKategori->where('kategori', $kategori);
        }     
        
        if (!empty($periode)) {
            $totalKategori->where('tanggal', 'LIKE', '%'.$periode.'%');
        } 
        
        $totalAll = DB::table('t_order')
                ->join('t_detail_order', 't_detail_order.id_order', '=', 't_order.id_order')
                ->join('m_item', 'm_item.id', '=', 't_detail_order.id_item')
                ->select([
                    DB::raw('sum(total) as total'),
                ]);
                
        if (!empty($kategori)) {
            $totalAll->where('kategori', $kategori);
        }        

        if (!empty($periode)) {
            $totalAll->where('tanggal', 'LIKE', '%'.$periode.'%');
        } 
       
        $totalTanggalMenu = $totalTanggalMenu->get();
        $totalMenu = $totalMenu->get();
        $totalTanggal = $totalTanggal->get();
        $totalKategori = $totalKategori->get();
        $totalAll = $totalAll->get();

        return [
            'perTanggalMenu' => $totalTanggalMenu,
            'perMenu' => $totalMenu,
            'perTanggal' => $totalTanggal,
            'perKategori' => $totalKategori,
            'total' => $totalAll[0]->total
        ];
    }

    // public function namamenu(){
    //     $menu = DB::table('m_item')
    //                     ->select('id', 'nama')->get();
    //     return $menu;
    // }


    public static function kategori($kategori, array $filter)
    {
        $listkategori = DB::table('m_item')
                        ->select('m_item.id as itemid', 'm_item.nama', 'm_item.kategori')
                        ->where('m_item.kategori', '=', $kategori)
                        ->whereNull('m_item.deleted_at')
                        ->orderBy('nama', 'asc');


        if (!empty($filter['kategori'])) {
            $listkategori->where('m_item.kategori', $filter['kategori']);
        }

        if (!empty($kategori)) {
            $listkategori->where('kategori', $kategori);
        }

        $listkategori = $listkategori->get();

        return $listkategori;
    }
}
