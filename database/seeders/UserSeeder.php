<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            'id_santri' => null,
            'nama' => 'Ihwan',
            'email' => 'InayAdmin@gmail.com',
            'akses' => 'admin',
            'password' => Hash::make('InayAdmin123'),
            'remember_token' => null,
            'is_aktif' => 1,
        ]);
    }
}
