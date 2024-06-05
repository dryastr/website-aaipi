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
        Schema::create('riwayat_pendidikan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('gelar_depan')->nullable();
            $table->string('gelar_belakang')->nullable();
            $table->string('nomor_ijazah')->nullable();
            $table->date('tanggal_ijazah')->nullable();
            $table->text('dokumen')->nullable();
            $table->enum('strata', ['sd/mi', 'smp/mts', 'sma/smk/ma', 'di', 'dii', 'diii', 'si/div', 'sii', 'siii']);
            $table->string('perguruan_tinggi')->nullable();
            $table->string('program_studi')->nullable();
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
        Schema::dropIfExists('riwayat_pendidikan');
    }
};
