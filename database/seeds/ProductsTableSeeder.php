<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'GTX 1080 8GB WindForce3x',
            'description' => 'Placa video de ultima generatie',
            'price' => 2599.99,
            'type' => 1,
        ]);
        DB::table('products')->insert([
            'name' => 'AMD R8 6GB',
            'description' => 'Placa video de ultima generatie',
            'price' => 2159.99,
            'type' => 1,
        ]);
        DB::table('products')->insert([
            'name' => 'Thinkpad',
            'description' => 'Laptop Intel I7, placa video integrata, 8GB RAM, 128GB SSD',
            'price' => 3000.00,
            'type' => 2,
        ]);
        DB::table('products')->insert([
            'name' => 'I7 4770k',
            'description' => 'CPU 4.3-4.5GHz',
            'price' => 1600.00,
            'type' => 3,
        ]);
        DB::table('products')->insert([
            'name' => 'I7 5500G',
            'description' => 'CPU 4.8-5GHz',
            'price' => 2199.99,
            'type' => 3,
        ]);
        DB::table('products')->insert([
            'name' => 'Razer Kraken',
            'description' => 'Casti Gaming',
            'price' => 400.00,
            'type' => 4,
        ]);
        DB::table('products')->insert([
            'name' => 'Razer Kraken Pro 5.0',
            'description' => 'Casti Gaming wireless',
            'price' => 510.00,
            'type' => 4,
        ]);
    }
}
