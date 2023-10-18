<?php

namespace App\Http\Controllers\Api\Master;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Helpers\Master\VoucherHelper;
use App\Http\Requests\voucher\CreateRequest;
use App\Http\Requests\voucher\UpdateRequest;
use App\Http\Requests\voucher\VoucherRequest;
use App\Http\Resources\Voucher\DetailResource;
use App\Http\Resources\voucher\VoucherResource;
use App\Http\Resources\voucher\VoucherCollection;

class VoucherController extends Controller
{
    protected $voucher;

    public function __construct()
    {
        $this->voucher = new VoucherHelper;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    {
        $filter = [
            'nama' => $request->nama ?? '',
            'id_customer' => $request->id_customer ?? '',
    ];
        $voucher = $this->voucher->getAll($filter,$request->per_page ?? 5, $request->sort ?? '');

        return response()->success(new VoucherCollection($voucher));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        /**
        * Menampilkan pesan error ketika validasi gagal
        * pengaturan validasi bisa dilihat pada class app/Http/request/User/CreateRequest
        */
        if (isset($request->validator) && $request->validator->fails()) {
            return response()->failed($request->validator->errors(), 422);
        }
        
        $dataInput = $request->only(['id_customer', 'id_promo', 'jumlah', 'jumlah_nominal', 'tanggal_mulai', 'periode_selesai', 'catatan']);
        $dataInput['id_promo'] = $dataInput['id_promo']['id'];
        // dd($dataInput);
        $dataVoucher = $this->voucher->create($dataInput);
        
        if (!$dataVoucher['status']) {
            return response()->failed($dataVoucher['error'], 422);
        }
        
        return response()->success([], 'Data voucher berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dataVoucher = $this->voucher->getById($id);

        if (empty($dataVoucher)) {
            return response()->failed(['Data voucher tidak ditemukan']);
        }

        return response()->success(new DetailResource($dataVoucher));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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

        $dataInput = $request->only(['id_customer', 'id_promo', 'jumlah', 'jumlah_nominal', 'tanggal_mulai', 'periode_selesai', 'catatan', 'id']);
        $dataVoucher = $this->voucher->update($dataInput, $dataInput['id']);
        
        if (!$dataVoucher['status']) {
            return response()->failed($dataVoucher['error']);
        }

        return response()->success(new VoucherResource($dataVoucher['data']), 'Data voucher berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dataVoucher = $this->voucher->delete($id);

        if (!$dataVoucher) {
            return response()->failed(['Mohon maaf data voucher tidak ditemukan']);
        }

        return response()->success($dataVoucher);
    }
}
