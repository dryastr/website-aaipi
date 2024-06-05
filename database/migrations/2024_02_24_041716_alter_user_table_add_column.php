<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Additional user details
            $table->string('nama_gelar', 150)->nullable();
            $table->string('nip', 50)->nullable();
            $table->string('nrp', 50)->nullable();

            // Job details
            $table->string('golongan_kode', 20)->nullable();
            $table->string('nama_pangkat', 255)->nullable();
            $table->string('kode_jenjang_jabatan', 10)->nullable();
            $table->string('kode_jabatan', 10)->nullable();
            $table->string('nama_jenjang_jabatan', 255)->nullable();
            $table->string('kelompok_jabatan', 20)->nullable();

            // Organizational details
            $table->string('kode_unit_kerja', 50)->nullable();
            $table->string('nama_unit', 255)->nullable();
            $table->string('kode_instansi', 50)->nullable();
            $table->string('nama_instansi', 255)->nullable();
            $table->boolean('is_auditor')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Reverse the changes made in the "up" method
            $table->dropColumn([
                'name_gelar',
                'jenis_kelamin',
                'user_nip',
                'user_nrp',
                'golongan_kode',
                'nama_pangkat',
                'kode_jenjang_jabatan',
                'kode_jabatan',
                'nama_jenjang_jabatan',
                'kelompok_jabatan',
                'kode_unit_kerja',
                'nama_unit',
                'kode_instansi',
                'nama_instansi',
                'is_auditor',
            ]);
        });
    }
};
