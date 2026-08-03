<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name'=>'Shohjaxon',
            'last_name'=>'Xurramov',
            'middle_name'=>'Shunkor o\'g\'li',
            'email'=>'sh@gmail.com',
            'phone'=>'1234567890',
            'login'=>'440231100200',
            'password'=>Hash::make('secret'),
        ]);

        $user->roles()->attach([1]);

        $user2 = User::create([
            'name'=>'Bexruz',
            'last_name'=>'Xoliqjonov',
            'middle_name'=>'Doniyor o\'g\'li',
            'email'=>'xb@gmail.com',
            'phone'=>'1234567890',
            'login'=>'440231100300',
            'password'=>Hash::make('secret'),  
        ]);

        $user2->roles()->attach([5]);

        $user3 = User::create([
            'name'=>'Muxlisa',
            'last_name'=>'Yuldosheva',
            'middle_name'=>'Maxsud qizi',
            'email'=>'my@gmail.com',
            'phone'=>'0987654321',
            'login'=>'440231100400',
            'password'=>Hash::make('secret'),  
        ]);

        $user3->roles()->attach([6]);

        $user4 = User::create([
            'name'=>'Tohir',
            'last_name'=>'Mirkomilov',
            'middle_name'=>'Maxsud o\'g\'li',
            'email'=>'txm@gmail.com',
            'phone'=>'1029387456',
            'login'=>'440231100500',
            'password'=>Hash::make('secret'),  
        ]);

        $user4->roles()->attach([7]);
    }
}
