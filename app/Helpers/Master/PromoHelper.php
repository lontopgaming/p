<?php

namespace App\Helpers\Master;

use App\Models\Master\PromoModel;
use App\Repository\CrudInterface;
use Illuminate\Support\Facades\Hash;

/**
 * Helper untuk manajemen user
 * Mengambil data, menambah, mengubah, & menghapus ke tabel user_auth
 *
 * @author Wahyu Agung <wahyuagung26@gmail.com>
 */
class PromoHelper implements CrudInterface
{
    private $promoModel;

    public function __construct()
    {
        $this->promoModel = new PromoModel();
    }

    /**
     * Mengambil data user dari tabel user_auth
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
        return $this->promoModel->getAll($filter, $itemPerPage, $sort);
    }

    /**
     * Mengambil 1 data user dari tabel user_auth
     *
     * @param  integer $id id dari tabel user_auth
     *
     * @return object
     */
    public function getById(int $id): object
    {
        return $this->promoModel->getById($id);
    }

    /**
     * method untuk menginput data baru ke tabel user_auth
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     *
     * @param array $payload
     * $payload['nama'] = string
     * $payload['email] = string
     * $payload['password] = string
     *
     * @return array
     */
    public function create(array $payload): array
    {
        try {
            
            if (!empty($payload['foto'])) {
                /**
                 * Parameter kedua ("gcs") digunakan untuk upload ke Google Cloud Service
                 * jika mau upload di server local, maka tidak usah pakai parameter kedua
                 */
                $foto = $payload['foto']->store('upload/fotoPromo');
                $payload['foto'] = $foto;
            }
            
            $promo = $this->promoModel->store($payload);
            return [
                'status' => true,
                'data' => $promo
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'error' => $th->getMessage()
            ];
        }
    }

    /**
     * method untuk mengubah user pada tabel user_auth
     *
     * @author Wahyu Agung <wahyuagung26@email.com>
     *
     * @param array $payload
     * $payload['nama'] = string
     * $payload['email] = string
     * $payload['password] = string
     *
     * @return array
     */
    public function update(array $payload, int $id): array
    {
        try {
           
            if (!empty($payload['foto'])) {
                /**
                 * Parameter kedua ("gcs") digunakan untuk upload ke Google Cloud Service, jika mau upload di server local, maka tidak usah pakai parameter kedua
                 */
                $foto = $payload['foto']->store('upload/fotoPromo');
                $payload['foto'] = $foto;
            } else {
                unset($payload['foto']); // Jika foto kosong, hapus dari array agar tidak diupdate
            }

            $this->promoModel->edit($payload, $id);
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
     * Menghapus data user dengan sistem "Soft Delete"
     * yaitu mengisi kolom deleted_at agar data tsb tidak
     * keselect waktu menggunakan Query
     *
     * @param  integer $id id dari tabel user_auth
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        try {
            $this->promoModel->drop($id);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
