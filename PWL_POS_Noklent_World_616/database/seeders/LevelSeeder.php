<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_level')->insert([
            'level_kode' => 'ADM',
            'level_nama' => 'Administrator',
        ]);

        DB::table('m_level')->insert([
            'level_kode' => 'MNG',
            'level_nama' => 'Manager',
        ]);
        DB::table('m_level')->insert([
            'level_kode' => 'KAS',
            'level_nama' => 'Kasir',
        ]);
    }
}
