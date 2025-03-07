<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_barang')->insert([
            'kategori_id' => 1,
            'barang_kode' => 'MKN-001',
            'barang_nama' => 'Nasi Goreng',
            'harga_jual' => 15000,
            'harga_beli' => 10000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('m_barang')->insert([
            'kategori_id' => 2,
            'barang_kode' => 'MNM-002',
            'barang_nama' => 'ES Degan',
            'harga_jual' => 12000,
            'harga_beli' => 8000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('m_barang')->insert([
            'kategori_id' => 3,
            'barang_kode' => 'DRK-003',
            'barang_nama' => 'Pudding',
            'harga_jual' => 10000,
            'harga_beli' => 7000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('m_barang')->insert([
            'kategori_id' => 4,
            'barang_kode' => 'LKS-004',
            'barang_nama' => 'Tissue',
            'harga_jual' => 5000,
            'harga_beli' => 3000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('m_barang')->insert([
            'kategori_id' => 5,
            'barang_kode' => 'SBS-005',
            'barang_nama' => 'Sosis',
            'harga_jual' => 7000,
            'harga_beli' => 5000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('m_barang')->insert([
            'kategori_id' => 1,
            'barang_kode' => 'MKN-002',
            'barang_nama' => 'Nasi Bakar',
            'harga_jual' => 17000,
            'harga_beli' => 12000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('m_barang')->insert([
            'kategori_id' => 2,
            'barang_kode' => 'MNM-001',
            'barang_nama' => 'Es Teh',
            'harga_jual' => 5000,
            'harga_beli' => 3000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('m_barang')->insert([
            'kategori_id' => 3,
            'barang_kode' => 'DRK-001',
            'barang_nama' => 'Puding Coklat',
            'harga_jual' => 12000,
            'harga_beli' => 8000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('m_barang')->insert([
            'kategori_id' => 4,
            'barang_kode' => 'LKS-001',
            'barang_nama' => 'Tissue Warna',
            'harga_jual' => 6000,
            'harga_beli' => 4000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('m_barang')->insert([
            'kategori_id' => 5,
            'barang_kode' => 'SBS-001',
            'barang_nama' => 'Sosis Ayam',
            'harga_jual' => 8000,
            'harga_beli' => 6000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


    }
}
