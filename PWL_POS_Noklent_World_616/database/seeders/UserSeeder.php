<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_user')->insert([
            'nama' => 'Administrator',
            'username' => 'admin@localhost',
            'password' => Hash::make('admin'),
            'level_id' => 1,
            'photo' => 'admin.png',
        ]);

        DB::table('m_user')->insert([
            'nama' => 'Manager',
            'username' => 'manager@localhost',
            'password' => Hash::make('manager'),
            'level_id' => 2,
            'photo' => 'manager.png',
        ]);

        DB::table('m_user')->insert([
            'nama' => 'Kasir',
            'username' => 'kasir@localhost',
            'password' => Hash::make('kasir'),
            'level_id' => 3,
            'photo' => 'kasir.png',
        ]);
    }
}
