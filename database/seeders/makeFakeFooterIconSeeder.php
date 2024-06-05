<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class makeFakeFooterIconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = [
            [
                'title' => 'Twitter',
                'link' => 'https://twitter.com/aaipi_id',
                'sosmed_icon' => 'fab fa-twitter',
            ],
            [
                'title' => 'Instagram',
                'link' => 'https://www.instagram.com/aaipi_id',
                'sosmed_icon' => 'fab fa-instagram',
            ],
        ];

        DB::table('icon_footer')->insert($data);
    }
}
