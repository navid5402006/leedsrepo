<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@leedsacademy.com',
            'password' => Hash::make('password123'),
        ]);

        Admin::create([
            'name' => 'Manager',
            'email' => 'manager@leedsacademy.com',
            'password' => Hash::make('password123'),
        ]);
    }
}