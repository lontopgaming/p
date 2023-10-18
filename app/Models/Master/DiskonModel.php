<?php

namespace App\Models\Master;

use App\Repository\ModelInterface;
use App\Http\Traits\RecordSignature;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Model untuk tabel user_auth
 * Dokumentasi Lengkap : https://laravel.com/docs/8.x/eloquent
 * 
 */
class DiskonModel extends Model implements ModelInterface
{
    use SoftDeletes, RecordSignature, HasRelationships, HasFactory;

     /**
     * Menentukan nama tabel yang terhubung dengan Class ini
     *
     * @var string
     */
    protected $table = 'diskon';

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
        'status'
    ];


    public function getAll(array $filter, int $itemPerPage = 0, string $sort = ''): object
    {
        $diskon = $this->query();

        if (!empty($filter['id_customer'])) {
            $diskon->where('id_customer', 'LIKE', '%'.$filter['id_customer'].'%');
        }

        if (!empty($filter['id_promo'])) {
            $diskon->where('id_promo', 'LIKE', '%'.$filter['id_promo'].'%');
        }

        if (!empty($filter['status'])) {
            $diskon->where('status', 'LIKE', '%'.$filter['status'].'%');
        }

        $sort = $sort ?: 'id DESC';
        $diskon->orderByRaw($sort);
        $itemPerPage = $itemPerPage > 0 ? $itemPerPage : false;
        
        return $diskon->paginate($itemPerPage)->appends('sort', $sort);
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
