<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bannerData = [
            [
                'title' => 'Telaah Sejawat',
                'desc' => 'Para auditor di lingkungan Aparat Pengawasan Intern Pemerintah (APIP) tentu tak
                asing dengan AAIPI. Ini adalah singkatan dari Asosiasi Auditor Intern Pemerintah
                Indonesia, suatu organisasi profesi yang mewadahi para auditor dan lembaga APIP di
                seluruh Indonesia',
                'image' => 'assets/img/banner/2024-02-09/289045ad-f61a-4f13-9874-4c9850fd217d_1707493717.jpg',
                'link' => 'https://aaipi.id/sejawat-app',
            ],
            [
                'title' => 'E-LMS',
                'desc' => 'Para auditor di lingkungan Aparat Pengawasan Intern Pemerintah (APIP) tentu tak
                asing dengan AAIPI. Ini adalah singkatan dari Asosiasi Auditor Intern Pemerintah
                Indonesia, suatu organisasi profesi yang mewadahi para auditor dan lembaga APIP di
                seluruh Indonesia',
                'image' => 'assets/img/banner/2024-02-09/0f6fd6d3-858c-48c5-b98f-75bb25c9f1d7_1707493686.jpg',
                'link' => 'https://aaipi.id/lms-app',
            ],
        ];

        Banner::insert($bannerData);
    }
}
