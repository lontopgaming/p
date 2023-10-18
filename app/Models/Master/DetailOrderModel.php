<?php

namespace App\Models\Master;

use App\Http\Traits\RecordSignature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;

class DetailOrderModel extends Model
{
    use  RecordSignature, HasRelationships;

     /**
     * Menentukan nama tabel yang terhubung dengan Class ini
     *
     * @var string
     */
    protected $table = 't_detail_order';

    /**
     * Menentukan primary key, jika nama kolom primary key adalah "id",
     * langkah deklarasi ini bisa dilewati
     *
     * @var string
     */
    protected $primaryKey = 'id_detail';

    /**
     * Akan mengisi kolom "created_at" dan "updated_at" secara otomatis,
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Mendeklarasikan nilai default dari setiap kolom pada tabel user_auth
     * jika suatu kolom tidak membutuhkan nilai default atau sudah diatur ketika membuat tabel
     * maka deklarasi ini bisa dilewati
     *
     * @var array
     */
    protected $attributes = [
        //
    ];

    protected $fillable = [
        //
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */


    public function getAll(array $filter, int $itemPerPage = 0, string $sort = ''): object
    {
        $detorder = $this->query();


        if (!empty($filter['kategori'])) {
            $detorder->where('kategori', 'LIKE', '%'.$filter['kategori'].'%');
        }

        if (!empty($filter['tanggal'])) {
            $detorder->where('tanggal', 'LIKE', '%'.$filter['tanggal'].'%');
        }

        $sort = $sort ?: 'id_detail DESC';
        $detorder->orderByRaw($sort);
        $itemPerPage = ($itemPerPage > 0) ? $itemPerPage : false ;

        return $detorder->paginate($itemPerPage)->appends('sort', $sort);
    }

    public function getById(int $id_detail): object
    {
        return $this->find($id_detail);
    }

    // public function item()
    // {
    //     return $this->hasOne(ItemModel::class, 'id', 'id_item');
    // }
}
