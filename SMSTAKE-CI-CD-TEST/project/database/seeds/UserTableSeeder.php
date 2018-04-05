<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(['name' => 'first',
                                    'email' => 'first@user.com',
                                    'password' => app('hash')->make('12345678'),
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
                                    ]);
        DB::table('users')->insert(['name' => 'second',
                                    'email' => 'second@user.com',
                                    'password' => app('hash')->make('12345678'),
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
