<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate([
            'name' => 'linty',
            'password' => encrypt('lty01234'),
            'phone' => '17605961742'
        ]);
    }
}
