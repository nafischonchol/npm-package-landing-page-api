<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    
    public function run(): void
    {
        User::create([
            "name"=> "Nafis Chonchol",
            "email"=> "nafis@gmail.com",
            "password"=> bcrypt("nafis@gmail.com"),
        ]);

        User::create([
            "name"=> "Mahfuz Rahman",
            "email"=> "mahfuz@gmail.com",
            "password"=> bcrypt("mahfuz@gmail.com"),
        ]);
    }
}
