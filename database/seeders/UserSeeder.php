<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'admin@mail.com',
        ], [
            'fullname' => 'Administrator',
            'password' => Hash::make('Password123'),
            'role_id' => 1,
        ]);
    }
}
