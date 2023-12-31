<?php

namespace App\Helpers\Master;

use App\Repository\CrudInterface;
use App\Models\Master\VoucherModel;

/**
 * Helper untuk manajemen voucher
 * Mengambil data, menambah, mengubah, & menghapus ke tabel m_voucher
 *
 * @author Wahyu Agung <wahyuagung26@gmail.com>
 */
class VoucherHelper implements CrudInterface
{
    private $voucherModel;

    public function __construct()
    {
        $this->voucherModel = new VoucherModel();
    }

    /**
     * Mengambil data voucher dari tabel m_voucher
     *
     * @author Wahyu Agung <wahyuagung26@gmail.com>
     *
     * @param  array $filter
     * $filter['nama'] = string
     * $filter['email'] = string
     * @param integer $itemPerPage jumlah data yang tampil dalam 1 halaman, kosongi jika ingin menampilkan semua data
     * @param string $sort nama kolom untuk melakukan sorting mysql beserta tipenya DESC / ASC
     *
     * @return object
     */
    public function getAll(array $filter, int $itemPerPage = 0, string $sort = ''): object
    {
        return $this->voucherModel->getAll($filter, $itemPerPage, $sort);
    }

    /**
     * Mengambil 1 data voucher dari tabel m_voucher
     *
     * @param  integer $id id dari tabel m_voucher
     * 
     * @return void
     */
    public function getById(int $id): object
    {
        return $this->voucherModel->getById($id);
    }

    /**
     * method untuk menginput data baru ke tabel m_voucher
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     *
     * @param array $payload
     * $payload['nama'] = string
     * $payload['email] = string
     * $payload['is_verified] = string
     *
     * @return array
     */
    public function create(array $payload): array
    {
        try {
            $voucher = $this->voucherModel->store($payload);
            
            return [
                'status' => true,
                'data' => $voucher
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage()
            ];
        }

        
    }

    /**
     * method untuk mengubah voucher pada tabel m_voucher
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     *
     * @param array $payload
     * $payload['nama'] = string
     * $payload['email] = string
     * $payload['is_verified] = boolean
     *
     * @return void
     */
    public function update(array $payload, int $id): array
    {
        try { 
            $this->voucherModel->edit($payload, $id);

            return [
                'status' => true,
                'data' => $this->getById($id)
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage()
            ];
        }
    }

    /**
     * Menghapus data voucher dengan sistem "Soft Delete"
     * yaitu mengisi kolom deleted_at agar data tsb tidak
     * keselect waktu menggunakan Query
     *
     * @param  integer $id id dari tabel m_voucher
     * @return bool
     */
    public function delete(int $id): bool
    {
        try {
            $this->voucherModel->drop($id);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}