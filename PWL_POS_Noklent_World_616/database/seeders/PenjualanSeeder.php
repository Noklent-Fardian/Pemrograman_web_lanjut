<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_penjualan')->insert([
            'user_id'=>3,
            'pembeli'=>'Budi',
            'penjualan_kode'=>'20210101',
            'tanggal_penjualan'=>'2021-01-01',
        ]);
        DB::table('t_penjualan')->insert([
            'user_id'=>3,
            'pembeli'=>'Ani',
            'penjualan_kode'=>'20210102',
            'tanggal_penjualan'=>'2021-01-02',
        ]);
        DB::table('t_penjualan')->insert([
            'user_id'=>3,
            'pembeli'=>'Citra',
            'penjualan_kode'=>'20210103',
            'tanggal_penjualan'=>'2021-01-03',
        ]);
        DB::table('t_penjualan')->insert([
            'user_id'=>3,
            'pembeli'=>'Dodi',
            'penjualan_kode'=>'20210104',
            'tanggal_penjualan'=>'2021-01-04',
        ]);
        DB::table('t_penjualan')->insert([
            'user_id'=>3,
            'pembeli'=>'Eka',
            'penjualan_kode'=>'20210105',
            'tanggal_penjualan'=>'2021-01-05',
        ]);
        DB::table('t_penjualan')->insert([
            'user_id'=>3,
            'pembeli'=>'Fajar',
            'penjualan_kode'=>'20210106',
            'tanggal_penjualan'=>'2021-01-06',
        ]);
        DB::table('t_penjualan')->insert([
            'user_id'=>3,
            'pembeli'=>'Galih',
            'penjualan_kode'=>'20210107',
            'tanggal_penjualan'=>'2021-01-07',
        ]);
        DB::table('t_penjualan')->insert([
            'user_id'=>3,
            'pembeli'=>'Hani',
            'penjualan_kode'=>'20210108',
            'tanggal_penjualan'=>'2021-01-08',
        ]);
    }
}
