<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\User();
        $user->email = 'muhammadgifary@gmail.com';
        $user->name ='Admin';
        $user->password = bcrypt('12345678');
        $user->save();
    }
}
