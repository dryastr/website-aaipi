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
        Schema::create('trans_tiket', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi');
            $table->unsignedBigInteger('ref_tiket_jenis_id');
            $table->foreign('ref_tiket_jenis_id')->references('id')->on('ref_tiket_jenis')->onDelete('cascade');
            $table->integer('prioritas')->default(1); // Kolom prioritas
            $table->text('attachment')->nullable(); // Kolom lampiran (nullable agar opsional)
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans_tiket');
    }
};
