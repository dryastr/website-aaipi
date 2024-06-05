<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class makeFakeBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'title' => 'Telaah Sejawat',
            'desc' => 'Para auditor di lingkungan Aparat Pengawasan Intern Pemerintah (APIP) tentu tak
            asing dengan AAIPI. Ini adalah singkatan dari Asosiasi Auditor Intern Pemerintah
            Indonesia, suatu organisasi profesi yang mewadahi para auditor dan lembaga APIP di
            seluruh Indonesia',
            'image' => 'assets/img/banner/slider-1.jpg',
            'link' => 'http://127.0.0.1:8000/sejawat-app',
        ];

        DB::table('banners')->insert($data);
    }
}
