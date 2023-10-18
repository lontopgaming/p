<?php

namespace App\Models\Master;

use App\Http\Traits\RecordSignature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;

class PromoModel extends Model
{
    use SoftDeletes, RecordSignature, HasRelationships;

     /**
     * Menentukan nama tabel yang terhubung dengan Class ini
     *
     * @var string
     */
    protected $table = 'promo';

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
        'nama',
        'type',
        'diskon',
        'nominal',
        'kadaluarsa',
        'syarat_ketentuan',
        'foto'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
   

    /**
     * Payload yang disimpan pada token JWT, jangan tampilkan informasi
     * yang bersifat rahasia pada payload ini untuk mengamankan akun pengguna
     *
     * @return array
     */
   

    /**
     * Relasi ke RoleModel / tabel user_roles
     *
     * @return void
     */
    

    /**
     * Method untuk mengecek apakah user memiliki permission
     *
     * @param  string  $permissionName contoh: user_create / user_update
     * 
     * @return boolean
     */
    

    /**
     * Menampilkan foto user dalam bentuk URL
     *
     * @return string
     */
    public function fotoUrl() {
        if(empty($this->foto)) {
            return asset('assets/img/no-image.png');
        } 

        return $this->foto;
    }

    public function getAll(array $filter, int $itemPerPage = 0, string $sort = ''): object
    {
        $promo = $this->query();

        if (!empty($filter['nama'])) {
            $promo->where('nama', 'LIKE', '%'.$filter['nama'].'%');
        }

        if (!empty($filter['type'])) {
            $promo->where('type', 'LIKE', '%'.$filter['type'].'%');
        }

        

        $sort = $sort ?: 'id DESC';
        $promo->orderByRaw($sort);
        $itemPerPage = ($itemPerPage > 0) ? $itemPerPage : false ;

        return $promo->paginate($itemPerPage)->appends('sort', $sort);
    }

    public function getById(int $id): object
    {
        return $this->find($id);
    }

    public function store(array $payload){
        return $this->create($payload);
    }

    public function edit(array $payload, int $id){
        return $this->find($id)->update($payload);
    }

    public function drop(int $id) {
        return $this->find($id)->delete();
    }
}
