<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class makeFakeSejarahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'title' => 'Sejarah Singkat',
                'description' => 'Website pemerintah adalah saluran resmi di dunia maya yang disediakan oleh pemerintah untuk menyampaikan informasi, memberikan layanan publik, dan memfasilitasi interaksi antara pemerintah dan masyarakat.',
                'daftar' => 'At vero eos et accusamus et iusto odio.',
                'image' => 'assets/img/about/01.jpg',
            ],
            [
                'id' => 2,
                'title' => null,
                'description' => null,
                'daftar' => 'Established fact that a reader will be distracted.',
                'image' => null,
            ],
            [
                'id' => 3,
                'title' => null,
                'description' => null,
                'daftar' => 'Sed ut perspiciatis unde omnis iste natus sit..',
                'image' => null,
            ],
        ];

        DB::table('about_history')->insert($data);
    }
}
