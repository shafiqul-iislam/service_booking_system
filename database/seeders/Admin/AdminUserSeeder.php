<?php

namespace Database\Seeders\Admin;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@site.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('12345678'), // Use a secure password in real apps
                'is_admin' => true,
            ]
        );
    }
}
