<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //DASHBOARD
        $menus = [
            'parent_id' => null,
            'title' => 'Home',
            'icon' => 'fa fa-home',
            'url' => '/',
            'order_menu' => 1,
            'type' => 'item',
            'permissions' => [
                [
                    'name' => 'View',
                    'action' => 'dashboard.view',
                ],
            ],
        ];

        $dashboard = Menu::updateOrCreate([
            'title' => $menus['title'],
            'type' => $menus['type'],
        ], Arr::except($menus, ['permissions']));

        foreach ($menus['permissions'] as $row) {
            $dashboard->permissions()->updateOrCreate([
                'name' => $row['name'],
                'action' => $row['action'],
            ], $row);
        }

        //VERIFIKASI
        $menus = [
            'parent_id' => null,
            'title' => 'Verifikasi',
            'icon' => null,
            'url' => null,
            'order_menu' => 2,
            'type' => 'section',
        ];

        $section = Menu::updateOrCreate([
            'title' => $menus['title'],
            'type' => $menus['type'],
        ], $menus);

        $childrens = [
            [
                'parent_id' => $section->id,
                'title' => 'Keanggotaan',
                'icon' => 'fas fa-user-check',
                'url' => 'verifikasi/keanggotaan',
                'order_menu' => 1,
                'type' => 'item',
                'permissions' => [
                    [
                        'name' => 'View',
                        'action' => 'verifikasi.keanggotaan.view',
                    ],
                    [
                        'name' => 'Decision',
                        'action' => 'verifikasi.keanggotaan.decision',
                    ],
                ],
            ],
            [
                'parent_id' => $section->id,
                'title' => 'Pembayaran',
                'icon' => 'fas fa-file-invoice-dollar',
                'url' => 'verifikasi/pembayaran',
                'order_menu' => 2,
                'type' => 'item',
                'permissions' => [
                    [
                        'name' => 'View',
                        'action' => 'verifikasi.pembayaran.view',
                    ],
                    [
                        'name' => 'Decision',
                        'action' => 'verifikasi.pembayaran.decision',
                    ],
                ],
            ],
        ];

        foreach ($childrens as $value) {
            $children = Menu::updateOrCreate([
                'title' => $value['title'],
                'type' => $value['type'],
            ], Arr::except($value, ['permissions']));

            foreach ($value['permissions'] as $row) {
                $children->permissions()->updateOrCreate([
                    'name' => $row['name'],
                    'action' => $row['action'],
                ], $row);
            }
        }

        // CMS
        $menus = [
            'parent_id' => null,
            'title' => 'CMS',
            'icon' => null,
            'url' => null,
            'order_menu' => 2,
            'type' => 'section',
        ];

        $section = Menu::updateOrCreate([
            'title' => $menus['title'],
            'type' => $menus['type'],
        ], $menus);

        // Home
        $menus = [
            'parent_id' => $section->id,
            'title' => 'Home',
            'icon' => 'fa fa-home',
            'url' => null,
            'order_menu' => 1,
            'type' => 'collapse',
        ];

        $parent = Menu::updateOrCreate([
            'title' => $menus['title'],
            'type' => $menus['type'],
        ], $menus);

        $childrens = [
            [
                'parent_id' => $parent->id,
                'title' => 'Banner',
                'icon' => 'far fa-file-image',
                'url' => 'CMS/banner',
                'order_menu' => 1,
                'type' => 'item',
                'permissions' => [
                    [
                        'name' => 'View',
                        'action' => 'CMS.banner.view',
                    ],
                    [
                        'name' => 'Create',
                        'action' => 'CMS.banner.create',
                    ],
                    [
                        'name' => 'Edit',
                        'action' => 'CMS.banner.edit',
                    ],
                    [
                        'name' => 'Delete',
                        'action' => 'CMS.banner.delete',
                    ],
                ],
            ], [
                'parent_id' => $parent->id,
                'title' => 'Galeri',
                'icon' => 'fas fa-images',
                'url' => 'CMS/galeri-kategori',
                'order_menu' => 2,
                'type' => 'item',
                'permissions' => [
                    [
                        'name' => 'View',
                        'action' => 'CMS.galeri-kategori.view',
                    ],
                    [
                        'name' => 'Create',
                        'action' => 'CMS.galeri-kategori.create',
                    ],
                    [
                        'name' => 'Edit',
                        'action' => 'CMS.galeri-kategori.edit',
                    ],
                    [
                        'name' => 'Delete',
                        'action' => 'CMS.galeri-kategori.delete',
                    ],
                ],
            ], [
                'parent_id' => $parent->id,
                'title' => 'Produk AAIPI',
                'icon' => 'fas fa-cogs',
                'url' => 'CMS/fungsi-unit-kerja',
                'order_menu' => 3,
                'type' => 'item',
                'permissions' => [
                    [
                        'name' => 'View',
                        'action' => 'CMS.fungsi-unit-kerja.view',
                    ],
                    [
                        'name' => 'Create',
                        'action' => 'CMS.fungsi-unit-kerja.create',
                    ],
                    [
                        'name' => 'Edit',
                        'action' => 'CMS.fungsi-unit-kerja.edit',
                    ],
                    [
                        'name' => 'Delete',
                        'action' => 'CMS.fungsi-unit-kerja.delete',
                    ],
                ],
            ], [
                'parent_id' => $parent->id,
                'title' => 'Sponsor',
                'icon' => 'fas fa-images',
                'url' => 'cms/sponsor',
                'order_menu' => 4,
                'type' => 'item',
                'permissions' => [
                    [
                        'name' => 'View',
                        'action' => 'cms.sponsor.view',
                    ],
                    [
                        'name' => 'Create',
                        'action' => 'cms.sponsor.create',
                    ],
                    [
                        'name' => 'Edit',
                        'action' => 'cms.sponsor.edit',
                    ],
                    [
                        'name' => 'Delete',
                        'action' => 'cms.sponsor.delete',
                    ],
                ],
            ],[
                'parent_id' => $parent->id,
                'title' => 'Iklan Banner',
                'icon' => 'fas fa-ad',
                'url' => 'cms/iklan-banner',
                'order_menu' => 5,
                'type' => 'item',
                'permissions' => [
                    [
                        'name' => 'View',
                        'action' => 'cms.iklan-banner.view',
                    ],
                    [
                        'name' => 'Create',
                        'action' => 'cms.iklan-banner.create',
                    ],
                    [
                        'name' => 'Edit',
                        'action' => 'cms.iklan-banner.edit',
                    ],
                    [
                        'name' => 'Delete',
                        'action' => 'cms.iklan-banner.delete',
                    ],
                ],
            ],
        ];

        foreach ($childrens as $value) {
            $children = Menu::updateOrCreate([
                'title' => $value['title'],
                'type' => $value['type'],
            ], Arr::except($value, ['permissions']));

            foreach ($value['permissions'] as $row) {
                $children->permissions()->updateOrCreate([
                    'name' => $row['name'],
                    'action' => $row['action'],
                ], $row);
            }
        }

        // Tentang Kami
        $menus = [
            'parent_id' => $section->id,
            'title' => 'Tentang Kami',
            'icon' => 'fa fa-home',
            'url' => null,
            'order_menu' => 2,
            'type' => 'collapse',
        ];

        $parent = Menu::updateOrCreate([
            'title' => $menus['title'],
            'type' => $menus['type'],
        ], $menus);

        $childrens = [
            [
                'parent_id' => $parent->id,
                'title' => 'Sejarah Singkat',
                'icon' => 'fas fa-landmark',
                'url' => 'cms/about-history',
                'order_menu' => 1,
                'type' => 'item',
                'permissions' => [
                    [
                        'name' => 'View',
                        'action' => 'about-history.view',
                    ],
                    [
                        'name' => 'Create',
                        'action' => 'about-history.create',
                    ],
                    [
                        'name' => 'Edit',
                        'action' => 'about-history.edit',
                    ],
                    [
                        'name' => 'Delete',
                        'action' => 'about-history.delete',
                    ],
                ],
            ], [
                'parent_id' => $parent->id,
                'title' => 'Visi Misi',
                'icon' => 'fas fa-edit',
                'url' => 'CMS/visi-misi',
                'order_menu' => 2,
                'type' => 'item',
                'permissions' => [
                    [
                        'name' => 'View',
                        'action' => 'CMS.visi-misi.view',
                    ],
                    [
                        'name' => 'Create',
                        'action' => 'CMS.visi-misi.create',
                    ],
                    [
                        'name' => 'Edit',
                        'action' => 'CMS.visi-misi.edit',
                    ],
                    [
                        'name' => 'Delete',
                        'action' => 'CMS.visi-misi.delete',
                    ],
                ],
            ], [
                'parent_id' => $parent->id,
                'title' => 'Struktur Organisasi',
                'icon' => 'fas fa-sitemap',
                'url' => 'CMS/struktur-organisasi',
                'order_menu' => 3,
                'type' => 'item',
                'permissions' => [
                    [
                        'name' => 'View',
                        'action' => 'CMS.struktur-organisasi.view',
                    ],
                    [
                        'name' => 'Create',
                        'action' => 'CMS.struktur-organisasi.create',
                    ],
                    [
                        'name' => 'Edit',
                        'action' => 'CMS.struktur-organisasi.edit',
                    ],
                    [
                        'name' => 'Delete',
                        'action' => 'CMS.struktur-organisasi.delete',
                    ],
                ],
            ], [
                'parent_id' => $parent->id,
                'title' => 'Program Kerja',
                'icon' => 'fas fa-clipboard',
                'url' => 'cms/program-kerja',
                'order_menu' => 4,
                'type' => 'item',
                'permissions' => [
                    [
                        'name' => 'View',
                        'action' => 'program-kerja.view',
                    ],
                    [
                        'name' => 'Create',
                        'action' => 'program-kerja.create',
                    ],
                    [
                        'name' => 'Edit',
                        'action' => 'program-kerja.edit',
                    ],
                    [
                        'name' => 'Delete',
                        'action' => 'program-kerja.delete',
                    ],
                ],
            ], [
                'parent_id' => $parent->id,
                'title' => 'Anggaran Dasar',
                'icon' => 'fas fa-money-check',
                'url' => 'anggaran-dasar',
                'order_menu' => 5,
                'type' => 'item',
                'permissions' => [
                    [
                        'name' => 'View',
                        'action' => 'anggaran-dasar.view',
                    ],
                    [
                        'name' => 'Create',
                        'action' => 'anggaran-dasar.create',
                    ],
                    [
                        'name' => 'Edit',
                        'action' => 'anggaran-dasar.edit',
                    ],
                    [
                        'name' => 'Delete',
                        'action' => 'anggaran-dasar.delete',
                    ],
                ],
            ],
        ];

        foreach ($childrens as $value) {
            $children = Menu::updateOrCreate([
                'title' => $value['title'],
                'type' => $value['type'],
            ], Arr::except($value, ['permissions']));

            foreach ($value['permissions'] as $row) {
                $children->permissions()->updateOrCreate([
                    'name' => $row['name'],
                    'action' => $row['action'],
                ], $row);
            }
        }

        $menus = [
            [
                'parent_id' => $section->id,
                'title' => 'Publikasi / Berita',
                'icon' => 'fas fa-newspaper',
                'url' => 'cms/news',
                'order_menu' => 3,
                'type' => 'item',
                'permissions' => [
                    [
                        'name' => 'View',
                        'action' => 'cms.news.view',
                    ],
                    [
                        'name' => 'Create',
                        'action' => 'cms.news.create',
                    ],
                    [
                        'name' => 'Edit',
                        'action' => 'cms.news.edit',
                    ],
                    [
                        'name' => 'Delete',
                        'action' => 'cms.news.delete',
                    ],
                ],
            ], [
                'parent_id' => $section->id,
                'title' => 'E-LMS AAIPI',
                'icon' => 'fas fa-book',
                'url' => 'CMS/lms-app',
                'order_menu' => 4,
                'type' => 'item',
                'permissions' => [
                    [
                        'name' => 'View',
                        'action' => 'CMS.lms-app.view',
                    ],
                    [
                        'name' => 'Create',
                        'action' => 'CMS.lms-app.create',
                    ],
                    [
                        'name' => 'Edit',
                        'action' => 'CMS.lms-app.edit',
                    ],
                    [
                        'name' => 'Delete',
                        'action' => 'CMS.lms-app.delete',
                    ],
                ],
            ], [
                'parent_id' => $section->id,
                'title' => 'Telaah Sejawat',
                'icon' => 'fas fa-book',
                'url' => 'cms/sejawat',
                'order_menu' => 5,
                'type' => 'item',
                'permissions' => [
                    [
                        'name' => 'View',
                        'action' => 'cms.sejawat.view',
                    ],
                    [
                        'name' => 'Create',
                        'action' => 'cms.sejawat.create',
                    ],
                    [
                        'name' => 'Edit',
                        'action' => 'cms.sejawat.edit',
                    ],
                    [
                        'name' => 'Delete',
                        'action' => 'cms.sejawat.delete',
                    ],
                ],
            ],
        ];

        foreach ($menus as $value) {
            $menus = Menu::updateOrCreate([
                'title' => $value['title'],
                'type' => $value['type'],
            ], Arr::except($value, ['permissions']));

            foreach ($value['permissions'] as $row) {
                $menus->permissions()->updateOrCreate([
                    'name' => $row['name'],
                    'action' => $row['action'],
                ], $row);
            }
        }

        $menus = [
            'parent_id' => $section->id,
            'title' => 'Kontak',
            'icon' => 'fas fa-phone',
            'url' => null,
            'order_menu' => 6,
            'type' => 'collapse',
        ];

        $parent = Menu::updateOrCreate([
            'title' => $menus['title'],
            'type' => $menus['type'],
        ], $menus);

        $childrens = [
            [
                'parent_id' => $parent->id,
                'title' => 'Kontak',
                'icon' => 'fas fa-phone',
                'url' => 'cms/kontak',
                'order_menu' => 1,
                'type' => 'item',
                'permissions' => [
                    [
                        'name' => 'View',
                        'action' => 'kontak.view',
                    ],
                    [
                        'name' => 'Create',
                        'action' => 'kontak.create',
                    ],
                    [
                        'name' => 'Edit',
                        'action' => 'kontak.edit',
                    ],
                    [
                        'name' => 'Delete',
                        'action' => 'kontak.delete',
                    ],
                ],
            ], [
                'parent_id' => $parent->id,
                'title' => 'Media Social',
                'icon' => 'fas fa-icons',
                'url' => 'cms/media-social',
                'order_menu' => 2,
                'type' => 'item',
                'permissions' => [
                    [
                        'name' => 'View',
                        'action' => 'CMS.icon-footer.view',
                    ],
                    [
                        'name' => 'Create',
                        'action' => 'CMS.icon-footer.create',
                    ],
                    [
                        'name' => 'Edit',
                        'action' => 'CMS.icon-footer.edit',
                    ],
                    [
                        'name' => 'Delete',
                        'action' => 'CMS.icon-footer.delete',
                    ],
                ],
            ], [
                'parent_id' => $parent->id,
                'title' => 'Pertanyaan',
                'icon' => 'fas fa-question-circle',
                'url' => 'pertanyaan',
                'order_menu' => 3,
                'type' => 'item',
                'permissions' => [
                    [
                        'name' => 'View',
                        'action' => 'pertanyaan.view',
                    ],
                    [
                        'name' => 'Create',
                        'action' => 'pertanyaan.create',
                    ],
                    [
                        'name' => 'Edit',
                        'action' => 'pertanyaan.edit',
                    ],
                    [
                        'name' => 'Delete',
                        'action' => 'pertanyaan.delete',
                    ],
                ],
            ],
        ];

        foreach ($childrens as $value) {
            $children = Menu::updateOrCreate([
                'title' => $value['title'],
                'type' => $value['type'],
            ], Arr::except($value, ['permissions']));

            foreach ($value['permissions'] as $row) {
                $children->permissions()->updateOrCreate([
                    'name' => $row['name'],
                    'action' => $row['action'],
                ], $row);
            }
        }

        //SETTING
        $menus = [
            'parent_id' => null,
            'title' => 'Setting',
            'icon' => null,
            'url' => null,
            'order_menu' => 98,
            'type' => 'section',
        ];

        $section = Menu::updateOrCreate([
            'title' => $menus['title'],
            'type' => $menus['type'],
        ], $menus);

        $childrens = [
            [
                'parent_id' => $section->id,
                'title' => 'Biaya Keanggotaan',
                'icon' => 'fas fa-money-bill-wave-alt',
                'url' => 'setting/biaya-keanggotaan',
                'order_menu' => 1,
                'type' => 'item',
                'permissions' => [
                    [
                        'name' => 'View',
                        'action' => 'setting.biaya-keanggotaan.view',
                    ],
                    [
                        'name' => 'Create',
                        'action' => 'setting.biaya-keanggotaan.create',
                    ],
                    [
                        'name' => 'Edit',
                        'action' => 'setting.biaya-keanggotaan.edit',
                    ],
                    [
                        'name' => 'Delete',
                        'action' => 'setting.biaya-keanggotaan.delete',
                    ],
                ],
            ],
            [
                'parent_id' => $section->id,
                'title' => 'Category Galeri',
                'icon' => 'fas fa-users-cog',
                'url' => 'setting/category-on-galeri',
                'order_menu' => 2,
                'type' => 'item',
                'permissions' => [
                    [
                        'name' => 'View',
                        'action' => 'setting.category-on-galeri.view',
                    ],
                    [
                        'name' => 'Create',
                        'action' => 'setting.category-on-galeri.create',
                    ],
                    [
                        'name' => 'Edit',
                        'action' => 'setting.category-on-galeri.edit',
                    ],
                    [
                        'name' => 'Delete',
                        'action' => 'setting.category-on-galeri.delete',
                    ],
                ],
            ], [
                'parent_id' => $section->id,
                'title' => 'Syarat Pendaftaran',
                'icon' => 'fas fa-user-tag',
                'url' => 'setting/syarat-pendaftaran',
                'order_menu' => 3,
                'type' => 'item',
                'permissions' => [
                    [
                        'name' => 'View',
                        'action' => 'setting.syarat-pendaftaran.view',
                    ],
                    [
                        'name' => 'Create',
                        'action' => 'setting.syarat-pendaftaran.create',
                    ],
                    [
                        'name' => 'Edit',
                        'action' => 'setting.syarat-pendaftaran.edit',
                    ],
                    [
                        'name' => 'Delete',
                        'action' => 'setting.syarat-pendaftaran.delete',
                    ],
                ],
            ],
        ];

        foreach ($childrens as $value) {
            $children = Menu::updateOrCreate([
                'title' => $value['title'],
                'type' => $value['type'],
            ], Arr::except($value, ['permissions']));

            foreach ($value['permissions'] as $row) {
                $children->permissions()->updateOrCreate([
                    'name' => $row['name'],
                    'action' => $row['action'],
                ], $row);
            }
        }

        //USER MANAGEMENT
        $menus = [
            'parent_id' => null,
            'title' => 'User Management',
            'icon' => null,
            'url' => null,
            'order_menu' => 99,
            'type' => 'section',
        ];

        $section = Menu::updateOrCreate([
            'title' => $menus['title'],
            'type' => $menus['type'],
        ], $menus);

        $childrens = [
            [
                'parent_id' => $section->id,
                'title' => 'User',
                'icon' => 'fa fa-users',
                'url' => 'user-management/user',
                'order_menu' => 1,
                'type' => 'item',
                'permissions' => [
                    [
                        'name' => 'View',
                        'action' => 'user-management.user.view',
                    ],
                    [
                        'name' => 'Create',
                        'action' => 'user-management.user.create',
                    ],
                    [
                        'name' => 'Edit',
                        'action' => 'user-management.user.edit',
                    ],
                    [
                        'name' => 'Delete',
                        'action' => 'user-management.user.delete',
                    ],
                ],
            ],
            [
                'parent_id' => $section->id,
                'title' => 'Role',
                'icon' => 'fas fa-users-cog',
                'url' => 'user-management/role',
                'order_menu' => 1,
                'type' => 'item',
                'permissions' => [
                    [
                        'name' => 'View',
                        'action' => 'user-management.role.view',
                    ],
                    [
                        'name' => 'Create',
                        'action' => 'user-management.role.create',
                    ],
                    [
                        'name' => 'Edit',
                        'action' => 'user-management.role.edit',
                    ],
                    [
                        'name' => 'Delete',
                        'action' => 'user-management.role.delete',
                    ],
                ],
            ],
            [
                'parent_id' => $section->id,
                'title' => 'Role Permission',
                'icon' => 'fas fa-user-shield',
                'url' => 'user-management/role-permission',
                'order_menu' => 1,
                'type' => 'item',
                'permissions' => [
                    [
                        'name' => 'View',
                        'action' => 'user-management.role-permission.view',
                    ],
                    [
                        'name' => 'Create',
                        'action' => 'user-management.role-permission.create',
                    ],
                ],
            ],
        ];

        foreach ($childrens as $value) {
            $children = Menu::updateOrCreate([
                'title' => $value['title'],
                'type' => $value['type'],
            ], Arr::except($value, ['permissions']));

            foreach ($value['permissions'] as $row) {
                $children->permissions()->updateOrCreate([
                    'name' => $row['name'],
                    'action' => $row['action'],
                ], $row);
            }
        }
    }
}
