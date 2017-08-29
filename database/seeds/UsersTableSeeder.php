<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'andrei',
            'email' => 'andrei.popa014@gmail.com',
            'password' => bcrypt('andrei'),
            'role' => 1,
        ]);
        DB::table('users')->insert([
            'name' => 'stefan',
            'email' => 'stefan@roweb.ro',
            'password' => bcrypt('stefan'),
            'role' => 1,
        ]);
        DB::table('users')->insert([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => bcrypt('user'),
            'role' => 0,
        ]);
    }
}
