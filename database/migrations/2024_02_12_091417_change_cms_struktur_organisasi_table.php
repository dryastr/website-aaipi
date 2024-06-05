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
        Schema::table('cms_struktur_organisasi', function (Blueprint $table) {
            $table->enum('jabatan', ['ketua', 'manajemen-eksekutif', 'komite-kode-etik', 'komite-standar-audit', 'komite-telaah-sejawat'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // You may need to revert the changes made in the 'up' method.
        // For this specific migration, dropping the 'cms_struktur_organisasi' table is not necessary.
    }
};
