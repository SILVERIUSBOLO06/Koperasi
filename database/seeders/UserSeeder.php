<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'no_anggota' => 'A01',
            'ktp' => '620202091101001',
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'jekel' => 'Laki-laki',
            'tempat_lahir' => 'Jogja',
            'tgl_lahir' => '1998-12-12',
            'tgl_masuk' => '2009-05-22',
            'pekerjaan' => 'Manager',
            'alamat' => 'Jl. Magelang',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'created_at' => \Carbon\Carbon::now(),
            'email_verified_at' => \Carbon\Carbon::now()
        ]);
        DB::table('users')->insert([
            'no_anggota' => '001',
            'ktp' => '620202091101003',
            'name' => 'Christoper Dori',
            'email' => 'dori@gmail.com',
            'jekel' => 'Laki-laki',
            'tempat_lahir' => 'Singkawang',
            'tgl_lahir' => '2001-10-09',
            'tgl_masuk' => '2022-12-08',
            'pekerjaan' => 'Mahasiswa',
            'alamat' => 'Jl. Kaliurang',
            'password' => Hash::make('dori'),
            'role' => 'anggota',
            'created_at' => \Carbon\Carbon::now(),
            'email_verified_at' => \Carbon\Carbon::now()
        ]);
    }
}
