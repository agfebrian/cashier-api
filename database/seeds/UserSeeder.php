<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'username' => 'admin',
            'email' => 'admin@cashierapp.com',
            'password' => bcrypt('12345678')
        ]);

        $user->assignRole('admin');

        $user = User::create([
            'username' => 'febrian',
            'email' => 'febrian@cashierapp.com',
            'password' => bcrypt('12345678')
        ]);

        $user->assignRole('operator');
    }
}
