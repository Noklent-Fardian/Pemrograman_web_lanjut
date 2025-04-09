<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Supplier;
use App\Models\UserModel;
use App\Models\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        
        $barangIds = Barang::pluck('barang_id')->toArray();
        $userIds = UserModel::pluck('user_id')->toArray();
        $supplierIds = Supplier::pluck('supplier_id')->toArray();
        
       
        for ($i = 0; $i < 20; $i++) {
            Stock::create([
                'barang_id' => $faker->randomElement($barangIds),
                'user_id' => $faker->randomElement($userIds),
                'supplier_id' => $faker->randomElement($supplierIds),
                'stok_tanggal_masuk' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'stok_jumlah' => $faker->numberBetween(10, 500),
            ]);
        }
    }
}