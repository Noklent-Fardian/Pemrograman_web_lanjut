<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_stock')->insert([
            'barang_id' => 1,
            'user_id' => 1,
            'stok_tanggal_masuk' => '2021-01-01',
            'stok_jumlah' => 100,
        ]);
        DB::table('t_stock')->insert([
            'barang_id' => 2,
            'user_id' => 1,
            'stok_tanggal_masuk' => '2021-01-01',
            'stok_jumlah' => 50,
        ]);
        DB::table('t_stock')->insert([
            'barang_id' => 3,
            'user_id' => 1,
            'stok_tanggal_masuk' => '2021-01-01',
            'stok_jumlah' => 200,
        ]);
        DB::table('t_stock')->insert([
            'barang_id' => 4,
            'user_id' => 1,
            'stok_tanggal_masuk' => '2021-01-01',
            'stok_jumlah' => 300,
        ]);
        DB::table('t_stock')->insert([
            'barang_id' => 5,
            'user_id' => 1,
            'stok_tanggal_masuk' => '2021-01-01',
            'stok_jumlah' => 150,
        ]);
        DB::table('t_stock')->insert([
            'barang_id' => 6,
            'user_id' => 1,
            'stok_tanggal_masuk' => '2021-01-01',
            'stok_jumlah' => 250,
        ]);
        DB::table('t_stock')->insert([
            'barang_id' => 7,
            'user_id' => 1,
            'stok_tanggal_masuk' => '2021-01-01',
            'stok_jumlah' => 100,
        ]);
        DB::table('t_stock')->insert([
            'barang_id' => 8,
            'user_id' => 1,
            'stok_tanggal_masuk' => '2021-01-01',
            'stok_jumlah' => 50,
        ]);
        DB::table('t_stock')->insert([
            'barang_id' => 9,
            'user_id' => 1,
            'stok_tanggal_masuk' => '2021-01-01',
            'stok_jumlah' => 200,
        ]);
        DB::table('t_stock')->insert([
            'barang_id' => 10,
            'user_id' => 1,
            'stok_tanggal_masuk' => '2021-01-01',
            'stok_jumlah' => 300,
        ]);
        
    }
}
