<?php

namespace App\Models\Master;

use App\Repository\ModelInterface;
use App\Http\Traits\RecordSignature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;

class VoucherModel extends Model implements ModelInterface
{
    use SoftDeletes, RecordSignature, HasRelationships, HasFactory;

     /**
     * Menentukan nama tabel yang terhubung dengan Class ini
     *
     * @var string
     */
    protected $table = 'voucher';

    /**
     * Menentukan primary key, jika nama kolom primary key adalah "id",
     * langkah deklarasi ini bisa dilewati
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Akan mengisi kolom "created_at" dan "updated_at" secara otomatis,
     *
     * @var bool
     */
    public $timestamps = true;

    protected $attributes = [

    ];

    protected $fillable = [
        'id_customer',
        'id_promo',
        'jumlah',
        'jumlah_nominal',
        'tanggal_mulai',
        'periode_selesai',
        'catatan'
    ];

    public function customer()
    {
        return $this->hasOne(CustomerModel::class, 'id', 'id_customer');
    }

    public function promo()
    {
        return $this->hasOne(PromoModel::class, 'id', 'id_promo');
    }

    public function getAll(array $filter, int $itemPerPage = 0, string $sort = ''): object
    {
        $voucher = $this->query();

        if (!empty($filter['id_customer'])) {
            $voucher->where('id_customer', 'LIKE', '%'.$filter['id_customer'].'%');
        }

        if (!empty($filter['id_promo'])) {
            $voucher->where('id_promo', 'LIKE', '%'.$filter['id_promo'].'%');
        }

        if (!empty($filter['jumlah'])) {
            $voucher->where('jumlah', 'LIKE', '%'.$filter['jumlah'].'%');
        }

        if (!empty($filter['nama'])) {
            $voucher->where('nama', 'LIKE', '%'.$filter['nama'].'%');
        }

        $sort = $sort ?: 'id DESC';
        $voucher->orderByRaw($sort);
        $itemPerPage = $itemPerPage > 0 ? $itemPerPage : false;
        
        return $voucher->paginate($itemPerPage)->appends('sort', $sort);
    }

    public function getById(int $id): object
    {
        return $this->find($id);
    }

    public function store(array $payload) {
        return $this->create($payload);
    }

    public function edit(array $payload, int $id) {
        return $this->find($id)->update($payload);
    }

    public function drop($id) {
        return $this->find($id)->delete();
    }
}
