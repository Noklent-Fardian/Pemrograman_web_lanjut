<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        for ($i = 1; $i <= 10; $i++) {
            $supplierCode = 'SUP-' . str_pad($i, 3, '0', STR_PAD_LEFT);
            $phoneNumber = '0' . $faker->numberBetween(800, 899) . $faker->numerify('######');
            
            DB::table('m_supplier')->insert([
                'supplier_kode' => $supplierCode,
                'name_supplier' => $faker->company,
                'supplier_contact' => $phoneNumber,
                'supplier_alamat' => $faker->address,
                'supplier_email' => $faker->companyEmail,
                'supplier_aktif' => $faker->boolean(80), 
                'supplier_keterangan' => $faker->paragraph(1),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}