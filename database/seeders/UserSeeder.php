<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'System Admin',
            'username' => 'admin',
            'email' => 'admin@pawforest.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'address' => 'Riga, Latvia',
            'date_joined' => now(),
        ]);
    }
}