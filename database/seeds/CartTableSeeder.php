<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('carts')->insert([
            'user_id' => 1,
            'product_id' => 3
        ]);
        DB::table('carts')->insert([
            'user_id' => 1,
            'product_id' => 1,
            'cantity' => 3
        ]);
        DB::table('carts')->insert([
            'user_id' => 1,
            'product_id' => 6,
            'cantity' => 2
        ]);
        DB::table('carts')->insert([
            'user_id' => 2,
            'product_id' => 4,
            'cantity' => 4
        ]);
        DB::table('carts')->insert([
            'user_id' => 2,
            'product_id' => 3
        ]);
        DB::table('carts')->insert([
            'user_id' => 2,
            'product_id' => 5
        ]);
    }
}
