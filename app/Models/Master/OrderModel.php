<?php

namespace App\Models\Master;

use App\Http\Traits\RecordSignature;
use App\Models\Master\CustomerModel;
use App\Models\Master\ItemModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use stdClass;

class OrderModel extends Model
{
    use RecordSignature;

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
     * Mendeklarasikan nilai default dari setiap kolom pada tabel m_user
     * jika suatu kolom tidak membutuhkan nilai default atau sudah diatur ketika membuat tabel
     * maka deklarasi ini bisa dilewati
     *
     * @var array
     */
    protected $attributes = [];

    protected $fillable = [
        'id_detail'
    ];

    public function chart($nama = '', $tanggal = '')
    {
        $list = DB::table('t_order')
            ->join('t_detail_order', 't_detail_order.id_order', '=', 't_order.id_order')
            ->join('m_item', 'm_item.id', '=', 't_detail_order.id_item')
            ->select([
                DB::raw('sum(total) as total'),
                DB::raw('DATE(tanggal) as bulan'),
                DB::raw('kategori as kategori')
            ])->groupBy('tanggal', 'kategori')->get();
        
        $food = [];
        $drink = [];
        $snack = [];

        foreach ($list as $data) {
            $date = date_create($data->bulan);
            $data->bulan = date_format($date,"m");

        }
        
        foreach ($list as $data) {
            if ($data->kategori == 'food') {
                $food[] = $data;
            } else if ($data->kategori == 'drink') {
                $drink[] = $data;
            } else if ($data->kategori == 'snack') {
                $snack[] = $data;
            }
        }

        // dd($food);

        $totalFood = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $totalDrink = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $totalSnack = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        
        foreach ($food as $data) {
            if($data->bulan == '01') {
                $totalFood[0] += $data->total;
            } else if ($data->bulan == '02') {
                $totalFood[1] += $data->total;
            } else if ($data->bulan == '03') {
                $totalFood[2] += $data->total;
            } else if ($data->bulan == '04') {
                $totalFood[3] += $data->total;
            } else if ($data->bulan == '05') {
                $totalFood[4] += $data->total;
            } else if ($data->bulan == '06') {
                $totalFood[5] += $data->total;
            } else if ($data->bulan == '07') {
                $totalFood[6] += $data->total;
            } else if ($data->bulan == '08') {
                $totalFood[7] += $data->total;
            } else if ($data->bulan == '09') {
                $totalFood[8] += $data->total;
            } else if ($data->bulan == '10') {
                $totalFood[9] += $data->total;
            } else if ($data->bulan == '11') {
                $totalFood[10] += $data->total;
            } else if ($data->bulan == '12') {
                $totalFood[11] += $data->total;
            }
        }

        foreach ($drink as $data) {
            if($data->bulan == '01') {
                $totalDrink[0] += $data->total;
            } else if ($data->bulan == '02') {
                $totalDrink[1] += $data->total;
            } else if ($data->bulan == '03') {
                $totalDrink[2] += $data->total;
            } else if ($data->bulan == '04') {
                $totalDrink[3] += $data->total;
            } else if ($data->bulan == '05') {
                $totalDrink[4] += $data->total;
            } else if ($data->bulan == '06') {
                $totalDrink[5] += $data->total;
            } else if ($data->bulan == '07') {
                $totalDrink[6] += $data->total;
            } else if ($data->bulan == '08') {
                $totalDrink[7] += $data->total;
            } else if ($data->bulan == '09') {
                $totalDrink[8] += $data->total;
            } else if ($data->bulan == '10') {
                $totalDrink[9] += $data->total;
            } else if ($data->bulan == '11') {
                $totalDrink[10] += $data->total;
            } else if ($data->bulan == '12') {
                $totalDrink[11] += $data->total;
            }
        }

        foreach ($snack as $data) {
            if($data->bulan == '01') {
                $totalSnack[0] += $data->total;
            } else if ($data->bulan == '02') {
                $totalSnack[1] += $data->total;
            } else if ($data->bulan == '03') {
                $totalSnack[2] += $data->total;
            } else if ($data->bulan == '04') {
                $totalSnack[3] += $data->total;
            } else if ($data->bulan == '05') {
                $totalSnack[4] += $data->total;
            } else if ($data->bulan == '06') {
                $totalSnack[5] += $data->total;
            } else if ($data->bulan == '07') {
                $totalSnack[6] += $data->total;
            } else if ($data->bulan == '08') {
                $totalSnack[7] += $data->total;
            } else if ($data->bulan == '09') {
                $totalSnack[8] += $data->total;
            } else if ($data->bulan == '10') {
                $totalSnack[9] += $data->total;
            } else if ($data->bulan == '11') {
                $totalSnack[10] += $data->total;
            } else if ($data->bulan == '12') {
                $totalSnack[11] += $data->total;
            }
        }
                
        return [
            'food' => $totalFood,
            'drink' => $totalDrink,
            'snack' => $totalSnack,
        ];
    }

    public function penjualan($nama = '', $tanggal = '')
    {
        $penjualan = DB::table('t_order')
                            ->join('t_detail_order as detail', 'detail.id_order', '=', 't_order.id_order')
                            ->join('m_item as m_item', 'm_item.id', '=', 'detail.id_item')
                            ->join('m_customer as m_customer', 'm_customer.id', '=', 't_order.id_user')
                            ->select([
                                DB::raw('m_customer.nama as nama_customer'),
                                DB::raw('m_item.nama as nama_item'),
                                DB::raw('total'),
                                DB::raw('jumlah'),
                                DB::raw('total_order'),
                                DB::raw('total_bayar'),
                                DB::raw('no_struk'),
                                DB::raw('potongan'),
                                DB::raw('diskon'),
                                DB::raw('DATE(tanggal) as tanggal'),
                            ]);
                            
        if (!empty($tanggal)) {
            $penjualan->where('tanggal', 'LIKE', '%'.$tanggal.'%');
        }        

        if (!empty($nama)) {
            $penjualan->where('m_customer.nama', 'LIKE', '%'.$nama.'%');
        } 

        $penjualan = $penjualan->get();

        $merged = [];
        foreach ($penjualan as $data){
            $i = 0;
            if ( array_key_exists($data->no_struk, $merged) ) {
                $order = new stdClass;
                $order->nama_item = $data->nama_item;
                $order->jumlah = $data->jumlah;
                $order->harga = $data->total;
                $order->total = ($data->total * $data->jumlah);

                $merged[$data->no_struk]->order[] = $order;
            } else {
                $order = new stdClass;
                $order->nama_item = $data->nama_item;
                $order->jumlah = $data->jumlah;
                $order->harga = $data->total;
                $order->total = ($data->total * $data->jumlah);

                $obj = new stdClass;
                $obj->no_struk = $data->no_struk;
                $obj->tanggal = $data->tanggal;
                $obj->nama_customer = $data->nama_customer;
                $obj->total_order = $data->total_order;
                $obj->total_bayar = $data->total_bayar;
                $obj->potongan = $data->potongan;
                $obj->diskon = $data->diskon;
                $obj->order[] = $order;
                
                
                
                $merged[$data->no_struk] = $obj;
            }
        }

        $res = [];
        foreach ($merged as $data) {
            $res[] = $data;
        }
        
        return $res;
        // return $merged;
        // dd($merged);
    }

    public function customer($customer = null, $periode = ''){
        $totalTanggalCustomer = DB::table('t_order')
                            ->select([
                                DB::raw('id_user as id_customer'),
                                DB::raw('DATE(tanggal) as tanggal'),
                                DB::raw('sum(total_order) as total')
                            ])
                            ->groupBy('id_user', 'tanggal');

        if (!empty($periode)) {
            $totalTanggalCustomer->where('tanggal', 'LIKE', '%'.$periode.'%');
        }        

        if (!empty($customer)) {
            $totalTanggalCustomer->where('id_user', $customer);
        } 

        $totalTanggal = DB::table('t_order')
                        ->select([
                            DB::raw('DATE(tanggal) as tanggal'),
                            DB::raw('sum(total_order) as total')
                        ])
                        ->groupBy('tanggal');

        if (!empty($periode)) {
            $totalTanggal->where('tanggal', 'LIKE', '%'.$periode.'%');
        }        

        if (!empty($customer)) {
            $totalTanggal->where('id_user', $customer);
        } 

        $totalCustomer = DB::table('t_order')
                        ->select([
                            DB::raw('id_user as id_customer'),
                            DB::raw('sum(total_order) as total')
                        ])
                        ->groupBy('id_user');

        if (!empty($periode)) {
            $totalCustomer->where('tanggal', 'LIKE', '%'.$periode.'%');
        }        

        if (!empty($customer)) {
            $totalCustomer->where('id_user', $customer);
        } 

        $totalAll = DB::table('t_order')
                        ->select([
                            DB::raw('sum(total_order) as total')
                        ]);

        if (!empty($periode)) {
            $totalAll->where('tanggal', 'LIKE', '%'.$periode.'%');
        }        

        if (!empty($customer)) {
            $totalAll->where('id_user', $customer);
        } 
        
        $totalTanggalCustomer = $totalTanggalCustomer->get();
        $totalTanggal = $totalTanggal->get();
        $totalCustomer = $totalCustomer->get();
        $totalAll = $totalAll->get();

        return [
            'perTanggalCustomer' => $totalTanggalCustomer,
            'perTanggal' => $totalTanggal,
            'perCustomer' => $totalCustomer,
            'total' => $totalAll[0]->total
        ];
    }

    public function menu($kategori = null, $periode = ''){
        $totalTanggalMenu = DB::table('t_order')
                ->join('t_detail_order', 't_detail_order.id_order', '=', 't_order.id_order')
                ->join('m_item', 'm_item.id', '=', 't_detail_order.id_item')
                ->select([
                    DB::raw('sum(total) as total'),
                    DB::raw('DATE(tanggal) as tanggal'),
                    DB::raw('id_item as id_menu'),
                    DB::raw('nama as nama_menu'),
                ])->groupBy('tanggal', 'id_item', 'nama');

        if (!empty($periode)) {
            $totalTanggalMenu->where('tanggal', 'LIKE', '%'.$periode.'%');
        }        

        if (!empty($kategori)) {
            $totalTanggalMenu->where('kategori', $kategori);
        } 
        
        $totalMenu = DB::table('t_order')
                ->join('t_detail_order', 't_detail_order.id_order', '=', 't_order.id_order')
                ->join('m_item', 'm_item.id', '=', 't_detail_order.id_item')
                ->select([
                    DB::raw('sum(total) as total'),
                    DB::raw('id_item as id_menu'),
                    DB::raw('nama as nama_menu'),
                ])->groupBy('id_item', 'nama');

        if (!empty($kategori)) {
            $totalMenu->where('kategori', $kategori);
        }     
        
        if (!empty($periode)) {
            $totalMenu->where('tanggal', 'LIKE', '%'.$periode.'%');
        } 

        $totalTanggal = DB::table('t_order')
                ->join('t_detail_order', 't_detail_order.id_order', '=', 't_order.id_order')
                ->join('m_item', 'm_item.id', '=', 't_detail_order.id_item')
                ->select([
                    DB::raw('sum(total) as total'),
                    DB::raw('DATE(tanggal) as tanggal')
                ])->groupBy('tanggal');

        if (!empty($kategori)) {
            $totalTanggal->where('kategori', $kategori);
        }        

        if (!empty($periode)) {
            $totalTanggal->where('tanggal', 'LIKE', '%'.$periode.'%');
        } 
        
        $totalKategori = DB::table('t_order')
                ->join('t_detail_order', 't_detail_order.id_order', '=', 't_order.id_order')
                ->join('m_item', 'm_item.id', '=', 't_detail_order.id_item')
                ->select([
                    DB::raw('sum(total) as total'),
                    DB::raw('kategori as kategori'),
                ])->groupBy('kategori');

        if (!empty($kategori)) {
            $totalKategori->where('kategori', $kategori);
        }     
        
        if (!empty($periode)) {
            $totalKategori->where('tanggal', 'LIKE', '%'.$periode.'%');
        } 
        
        $totalAll = DB::table('t_order')
                ->join('t_detail_order', 't_detail_order.id_order', '=', 't_order.id_order')
                ->join('m_item', 'm_item.id', '=', 't_detail_order.id_item')
                ->select([
                    DB::raw('sum(total) as total'),
                ]);
                
        if (!empty($kategori)) {
            $totalAll->where('kategori', $kategori);
        }        

        if (!empty($periode)) {
            $totalAll->where('tanggal', 'LIKE', '%'.$periode.'%');
        } 
       
        $totalTanggalMenu = $totalTanggalMenu->get();
        $totalMenu = $totalMenu->get();
        $totalTanggal = $totalTanggal->get();
        $totalKategori = $totalKategori->get();
        $totalAll = $totalAll->get();

        return [
            'perTanggalMenu' => $totalTanggalMenu,
            'perMenu' => $totalMenu,
            'perTanggal' => $totalTanggal,
            'perKategori' => $totalKategori,
            'total' => $totalAll[0]->total
        ];
    }

    // public function customer()
    // {
    //     return $this->hasOne(CustomerModel::class, 'id', 'id_user');
    // }

    public function detail()
    {
        return $this->hasOne(OrderDetModel::class, 'id_detail', 'id_order');
    }

    public function item()
    {
        return $this->hasOne(ItemModel::class, 'id', 'id_item');
    }

    public function getFilterKategori($id = 'all')
    {
        if($id == 'all'){
            return '';
        }
        $kategori = DB::table('m_item')
                ->select([
                    DB::raw('kategori'),
                ])->where('id', $id)->first();
        return $kategori->kategori;
    }

    public function getFilterTanggal($id = 'all')
    {
        if($id == 'all'){
            return '';
        }
        $tanggal = DB::table('t_order')
                ->select([
                    DB::raw('tanggal'),
                ])->where('id_order', $id)->first();
        $filter = date('Y-m', strtotime($tanggal->tanggal));
        return $filter;
    }

    public function getAll(array $filter, int $itemPerPage = 0, string $sort = '')
    {
        $order = $this->query();
        
        if (!empty($filter['id_item'])) {
            $order->where('id_item', $filter['id_item']);
        }

        if (!empty($filter['tanggal'])) {    
            $order->whereRelation('item', 'tanggal', 'LIKE', '%'.$filter['periode'].'%');
        }

        if (!empty($filter['kategori'])) {
            $order->whereRelation('item', 'kategori', $filter['kategori']);
        } else {
            return [];
        }

        $sort = $sort ?: 'id_detail ASC';
        $order->orderByRaw($sort ?: 'id_detail ASC');
        
        $itemPerPage = false;
        return $order->paginate(10000000);
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

    public function drop(int $id) {
        return $this->find($id)->delete();
    }
}
