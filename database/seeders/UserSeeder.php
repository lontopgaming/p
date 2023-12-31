<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Membuat database default untuk tabel m_user dan m_roles
 * Jalankan perintah "php artisan db:seed --class=UserSeeder" pada terminal
 */
class UserSeeder extends Seeder
{
    public function run()
    {
        // Input data default untuk tabel m_roles
        DB::table('user_roles')->insert([
            'id' => 1,
            'nama' => 'Super Admin',
            'akses' => '{
                "user": {"create": true, "update": true, "delete": true, "view": true}, 
                "roles": {"create": true, "update": true, "delete": true, "view": true}
            }',
        ]);

        // Input data default untuk tabel m_user
        DB::table('user_auth')->insert([
            'id' => 1,
            'user_roles_id' => 1,
            'nama' => 'Yupi',
            'email' => 'yupi@landa.co.id',
            'password' => Hash::make('devganteng'),
            'updated_security' => date('Y-m-d H:i:s')
        ]);
    }
}






