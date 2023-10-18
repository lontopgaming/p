<?php

namespace App\Http\Controllers\Api\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Master\DetailOrderModel;

class DetailOrderController extends Controller
{
    private $detorder;

    public function __construct()
    {
        $this->detorder = new DetailOrderModel();
    }


    /**
     * Mengambil data user dilengkapi dengan pagination
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function index(Request $request)
    {
        $filter = [
            'kategori' => $request->kategori ?? '',
            'tanggal' => $request->tanggal ?? '',
        ];
        $detorders = $this->detorder->getAll($filter, $request->itemperpage ?? 0, $request->sort ?? '');

        return response()->success($detorders);
    }

    /**
     * Membuat data user baru & disimpan ke tabel user_auth
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
   
    public function show($id)
    {
        $dataDetOrder = $this->detorder->getById($id);

        if (empty($dataOrder)) {
            return response()->failed(['Data tidak ditemukan']);
        }

        return response()->success($dataDetOrder);
    }

    /**
     * Mengubah data user di tabel user_auth
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
}
