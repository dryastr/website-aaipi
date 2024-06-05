<?php

namespace Database\Seeders;

use App\Models\SyaratPendaftaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class SyaratPendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'parent_id' => null,
                'title' => 'Mengisi formulir pendaftaran anggota luar biasa',
                'label' => null,
                'type' => 'text',
                'order_position' => 1,
                'childrens' => [],
            ],
            [
                'id' => 2,
                'parent_id' => null,
                'title' => 'Melampirkan beberapa dokumen yang terdiri dari',
                'label' => null,
                'type' => 'text',
                'order_position' => 2,
                'childrens' => [
                    [
                        'id' => 3,
                        'parent_id' => 2,
                        'title' => 'Pas foto',
                        'label' => 'Pas Foto',
                        'type' => 'file',
                        'order_position' => 1,
                    ],
                    [
                        'id' => 4,
                        'parent_id' => 2,
                        'title' => 'Surat permohonan atau usulan dari Dewan Pengurus Nasional atau Dewan Pengurus Wilayah',
                        'label' => 'Surat permohonan atau usulan dari Dewan Pengurus Nasional atau Dewan Pengurus Wilayah',
                        'type' => 'file',
                        'order_position' => 2,
                    ],
                    [
                        'id' => 5,
                        'parent_id' => 2,
                        'title' => 'Surat pernyataan tidak sedang menjadi anggota organisasi profesi dari jabatan fungsional lainnya',
                        'label' => 'Surat pernyataan tidak sedang menjadi anggota organisasi profesi dari jabatan fungsional lainnya',
                        'type' => 'file',
                        'order_position' => 3,
                    ],
                    [
                        'id' => 6,
                        'parent_id' => 2,
                        'title' => 'Surat pernyataan pernah menduduki Jabatan Fungsional Auditor, Jabatan Pimpinan, Tinggi atau Jabatan Administrasi di lingkungan APIP',
                        'label' => 'Surat pernyataan pernah menduduki Jabatan Fungsional Auditor, Jabatan Pimpinan, Tinggi atau Jabatan Administrasi di lingkungan APIP',
                        'type' => 'file',
                        'order_position' => 4,
                    ],
                    [
                        'id' => 7,
                        'parent_id' => 2,
                        'title' => 'Lembar pernyataan persetujuan terhadap AD / ART AAIPI',
                        'label' => 'Lembar pernyataan persetujuan terhadap AD / ART AAIPI',
                        'type' => 'file',
                        'order_position' => 5,
                    ],
                ],
            ],
        ];

        foreach ($data as $row) {
            SyaratPendaftaran::updateOrCreate([
                'id' => $row['id'],
            ], Arr::except($row, ['childrens']));

            foreach ($row['childrens'] as $item) {
                SyaratPendaftaran::updateOrCreate([
                    'id' => $item['id'],
                ], $item);

            }
        }
    }
}
