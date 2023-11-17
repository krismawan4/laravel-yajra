<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 50; $i++) {
            DB::table('riki_produk')->insert([
                'nama' => $faker->name,
                'harga' => $faker->numberBetween($min = 10_000),
                'created_at' => $faker->date('Y-m-d'),
            ]);
        }
    }
}
