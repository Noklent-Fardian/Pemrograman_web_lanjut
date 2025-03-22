<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_penjualan_detail')->insert([
            'penjualan_id' => 1,
            'barang_id' => 1,
            'jumlah_barang' => 2,
            'harga_barang' => 10000,


        ]);
        DB::table('t_penjualan_detail')->insert([
            'penjualan_id' => 1,
            'barang_id' => 1,
            'jumlah_barang' => 3,
            'harga_barang' => 10000,


        ]);
        DB::table('t_penjualan_detail')->insert([
            'penjualan_id' => 1,
            'barang_id' => 1,
            'jumlah_barang' => 5,
            'harga_barang' => 10000,


        ]);
        DB::table('t_penjualan_detail')->insert([
            'penjualan_id' => 1,
            'barang_id' => 3,
            'jumlah_barang' => 2,
            'harga_barang' => 20000,

        ]);
        DB::table('t_penjualan_detail')->insert([
            'penjualan_id' => 1,
            'barang_id' => 4,
            'jumlah_barang' => 1,
            'harga_barang' => 5000,

        ]);
        DB::table('t_penjualan_detail')->insert([
            'penjualan_id' => 2,
            'barang_id' => 1,
            'jumlah_barang' => 10,
            'harga_barang' => 10000,

        ]);
        DB::table('t_penjualan_detail')->insert([
            'penjualan_id' => 2,
            'barang_id' => 2,
            'jumlah_barang' => 5,
            'harga_barang' => 12000,

        ]);
        DB::table('t_penjualan_detail')->insert([
            'penjualan_id' => 2,
            'barang_id' => 3,
            'jumlah_barang' => 3,
            'harga_barang' => 20000,

        ]);
        DB::table('t_penjualan_detail')->insert([
            'penjualan_id' => 2,
            'barang_id' => 4,
            'jumlah_barang' => 2,
            'harga_barang' => 5000,

        ]);
        DB::table('t_penjualan_detail')->insert([
            'penjualan_id' => 2,
            'barang_id' => 5,
            'jumlah_barang' => 1,
            'harga_barang' => 7000,

        ]);
        DB::table('t_penjualan_detail')->insert([
            'penjualan_id' => 3,
            'barang_id' => 1,
            'jumlah_barang' => 15,
            'harga_barang' => 10000,

        ]);
    }
}
