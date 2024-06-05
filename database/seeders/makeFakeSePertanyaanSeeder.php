<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class makeFakeSePertanyaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'pertanyaan' => 'Keanggotaan AAIP & PErsyarata?',
            'jawaban' => 'Anggota Biasa terdiri dari Perorangan Yang memiliki tugas pokok dan kewenangan',
        ];

        DB::table('pertanyaan')->insert($data);
    }
}
