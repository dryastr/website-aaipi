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
        Schema::create('riwayat_jabatan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('nip_nrp');
            $table->enum('status_nip_nrp', ['nip', 'nrp']);
            $table->string('kode_jenjang_jabatan', 10)->nullable();
            $table->string('kode_jabatan')->nullable();
            $table->string('nama_jenjang_jabatan')->nullable();
            $table->integer('level_jenjang_jabatan')->nullable();
            $table->string('nomor_sk')->nullable();
            $table->date('tanggal_sk')->nullable();
            $table->date('tmt_jabatan')->nullable();
            $table->text('dokumen')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_jabatan');
    }
};
