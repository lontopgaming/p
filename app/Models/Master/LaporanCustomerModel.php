<?php

namespace App\Models\Master ;

use Illuminate\Support\Facades\DB;
use App\Http\Traits\RecordSignature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LaporanCustomerModel extends Model
{
    use HasFactory;

        public static function customer($customer = null, $periode = ''){
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

        public function namacust(){
            $customer = DB::table('m_customer')
                            ->select('id', 'nama')->get();
            return $customer;
        }

 
}
