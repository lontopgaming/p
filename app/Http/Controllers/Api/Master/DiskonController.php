<?php

namespace App\Http\Controllers\Api\Master;

use Illuminate\Http\Request;
use App\Helpers\Master\DiskonHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\diskon\CreateRequest;
use App\Http\Requests\diskon\UpdateRequest;
use App\Http\Resources\diskon\DetailResource;
use App\Http\Resources\diskon\DiskonResource;
use App\Http\Resources\diskon\DiskonCollection;

class DiskonController extends Controller
{
    private $diskon;

    public function __construct()
    {
        $this->diskon = new DiskonHelper();
    }

    /**
     * Mengambil data user dilengkapi dengan pagination
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function index(Request $request)
    {
        $filter = [
            'id_diskon' => $request-> id_diskon ?? '',
            'id_customer' => $request->id_customer ?? '',
            'id_promo' => $request->id_promo ?? '',
            'listdiskon' => $request->listdiskon ?? PHP_INT_MAX,        
        ];
        $diskon = $this->diskon->getAll($filter, $request -> itemperpage ?? 10000, $request->sort ?? '');

        return response()->success(new DiskonCollection($diskon));
    }

    /**
     * Membuat data user baru & disimpan ke tabel user_auth
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */

    public function store(CreateRequest $request)
    {
        /**
         * Menampilkan pesan error ketika validasi gagal
         * pengaturan validasi bisa dilihat pada class app/Http/request/User/CreateRequest
         */
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        $dataInput = $request->only(['id_customer', 'id_promo', 'status']);
        $dataDiskon = $this->diskon->create($dataInput);
        
        if (!$dataDiskon['status']) {
            return response()->failed($dataDiskon['error']);
        }

        return response()->success(new DiskonResource($dataDiskon['data']), 'Data  berhasil disimpan');
    }

    /**
     * Menampilkan user secara spesifik dari tabel user_auth
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function show($id)
    {
        $dataDiskon = $this->diskon->getById($id);

        if (empty($dataDiskon)) {
            return response()->failed(['Data  tidak ditemukan']);
        }

        return response()->success(new DetailResource($dataDiskon));
    }

    /**
     * Mengubah data user di tabel user_auth
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function update(UpdateRequest $request)
    {
        /**
         * Menampilkan pesan error ketika validasi gagal
         * pengaturan validasi bisa dilihat pada class app/Http/request/User/UpdateRequest
         */
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors());
        }

        $dataInput = $request->only(['id_customer', 'id_promo','status','id']);
        $dataDiskon = $this->diskon->update($dataInput, $dataInput['id']);

        if (!$dataDiskon['status']) {
            return response()->failed($dataDiskon['error']);
        }

        return response()->success(new DiskonResource($dataDiskon['data']), 'Data berhasil disimpan');
    }

    /**
     * Soft delete data user
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
}

