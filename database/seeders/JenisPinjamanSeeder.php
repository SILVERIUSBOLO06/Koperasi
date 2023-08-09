<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class JenisPinjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jenis_pinjaman')->insert([
            'jenis_pinjaman' => 'Pinjaman Kecil',
            'max' => '10000000',
            'bunga' => '9',
            'lama' => '12'
        ]);
        DB::table('jenis_pinjaman')->insert([
            'jenis_pinjaman' => 'Pinjaman Sedang',
            'max' => '50000000',
            'bunga' => '9',
            'lama' => '12'
        ]);
        DB::table('jenis_pinjaman')->insert([
            'jenis_pinjaman' => 'Pinjaman Besar',
            'max' => '100000000',
            'bunga' => '9',
            'lama' => '12'
        ]);
    }
}
