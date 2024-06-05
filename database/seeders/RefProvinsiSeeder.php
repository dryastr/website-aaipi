<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefProvinsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::unprepared("
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (1, '11', 'Aceh', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (2, '51', 'Bali', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (3, '36', 'Banten', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (4, '17', 'Bengkulu', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (5, '34', 'Daerah Istimewa Yogyakarta', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (6, '31', 'DKI Jakarta', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (7, '15', 'Jambi', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (8, '32', 'Jawa Barat', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (9, '75', 'Gorontalo', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (10, '33', 'Jawa Tengah', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (11, '35', 'Jawa Timur', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (12, '61', 'Kalimantan Barat', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (13, '63', 'Kalimantan Selatan', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (14, '62', 'Kalimantan Tengah', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (15, '65', 'Kalimantan Utara', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (16, '19', 'Kepulauan Bangka Belitung', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (17, '64', 'Kalimantan Timur', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (18, '18', 'Lampung', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (19, '21', 'Kepulauan Riau', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (20, '81', 'Maluku', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (21, '82', 'Maluku Utara', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (22, '52', 'Nusa Tenggara Barat', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (23, '53', 'Nusa Tenggara Timur', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (24, '91', 'Papua', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (25, '92', 'Papua Barat', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (26, '14', 'Riau', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (27, '76', 'Sulawesi Barat', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (28, '73', 'Sulawesi Selatan', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (29, '72', 'Sulawesi Tengah', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (30, '74', 'Sulawesi Tenggara', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (31, '71', 'Sulawesi Utara', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (32, '13', 'Sumatera Barat', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (33, '16', 'Sumatera Selatan', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
            INSERT INTO `ref_provinsi` (`id`, `kode`, `nama`, `is_active`, `created_by`, `created_by_name`, `updated_by`, `updated_by_name`, `created_at`, `updated_at`) VALUES (34, '12', 'Sumatera Utara', 1, NULL, 'System', NULL, 'System', NOW(), NOW());
        ");
    }
}
