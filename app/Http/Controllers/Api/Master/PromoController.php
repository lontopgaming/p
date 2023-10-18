<?php

namespace App\Http\Controllers\Api\Master;

use Illuminate\Http\Request;
use App\Helpers\Master\PromoHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Promo\CreateRequest;
use App\Http\Requests\Promo\UpdateRequest;
use App\Http\Resources\Promo\PromoResource;
use App\Http\Resources\Promo\DetailResource;
use App\Http\Resources\Promo\PromoCollection;



class PromoController extends Controller
{
    private $promo;

    public function __construct()
    {
        $this->promo = new PromoHelper();
    }

    /**
     * Mengambil data user dilengkapi dengan pagination
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function index(Request $request)
    {
        $filter = [
            'nama' => $request->nama ?? '',
            'type' => $request->type ?? '',
        ];
        $promo = $this->promo->getAll($filter, $request->itemperpage ?? 0, $request->sort ?? '');

        return response()->success(new PromoCollection($promo));
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

        $dataInput = $request->only(['nama', 'type', 'diskon', 'nominal', 'kadaluarsa', 'syarat_ketentuan', 'foto']);
        $dataPromo = $this->promo->create($dataInput);
        
        if (!$dataPromo['status']) {
            return response()->failed($dataPromo['error']);
        }

        return response()->success(new PromoResource($dataPromo['data']), 'Data berhasil disimpan');
    }

    /**
     * Menampilkan user secara spesifik dari tabel user_auth
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function show($id)
    {
        $dataPromo = $this->promo->getById($id);

        if (empty($dataPromo)) {
            return response()->failed(['Data tidak ditemukan']);
        }

        return response()->success(new DetailResource($dataPromo));
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

        $dataInput = $request->only(['id', 'nama', 'type', 'diskon', 'nominal', 'kadaluarsa', 'syarat_ketentuan', 'foto']);
        $dataPromo = $this->promo->update($dataInput, $dataInput['id']);

        if (!$dataPromo['status']) {
            return response()->failed($dataPromo['error']);
        }

        return response()->success(new PromoResource($dataPromo['data']), 'Data berhasil disimpan');
    }

    /**
     * Soft delete data user
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     */
    public function destroy($id)
    {
        $dataPromo = $this->promo->delete($id);

        if (!$dataPromo) {
            return response()->failed(['Mohon maaf data tidak ditemukan']);
        }

        return response()->success($dataPromo, 'Data telah dihapus');
    }
}
