<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         User::create([
            'email' => 'mustafa@gmail.com',
            'password' => Hash::make('123456789'),
            'role' => 'admin',
            'name' => 'mustafa',
        ]);
    }
}
