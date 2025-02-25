<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_kategori')->insert([
            'kategori_kode' => 'MKN',
            'kategori_nama' => 'Makanan',
        ]);

        DB::table('m_kategori')->insert([
            'kategori_kode' => 'MNM',
            'kategori_nama' => 'Minuman',
        ]);
        DB::table('m_kategori')->insert([
            'kategori_kode' => 'DRK',
            'kategori_nama' => 'Dessert',
        ]);
        DB::table('m_kategori')->insert([
            'kategori_kode' => 'LKS',
            'kategori_nama' => 'Lain-lain',
        ]);
        DB::table('m_kategori')->insert([
            'kategori_kode' => 'BHS',
            'kategori_nama' => 'Bahan Baku',
        ]);
    }
}
