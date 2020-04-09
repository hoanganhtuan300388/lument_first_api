<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'email'         => 'hoanganhtuan.30388@gmail.com',
            'password'      => Hash::make('123@123Aa'),
            'first_name'    => 'Hoàng Anh',
            'last_name'     => 'Tuấn',
        ]);
    }
}
