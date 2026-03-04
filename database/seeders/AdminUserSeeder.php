<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@enzo.test'],
            [
                'name' => 'Admin EnzoPrestige',
                'password' => Hash::make('Admin123!'),
                'role' => 'admin',
            ]
        );
    }
}
