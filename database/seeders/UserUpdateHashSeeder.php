<?php

namespace Database\Seeders;

use App\Helpers\AaipiHasher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserUpdateHashSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hashedPassword = app(AaipiHasher::class)->make('password');
        DB::table('users')->update(['password' => $hashedPassword]);
    }
}
