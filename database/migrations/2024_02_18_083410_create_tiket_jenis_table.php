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
        Schema::create('ref_tiket_jenis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('prioritas')->default(1); // Kolom prioritas untuk jenis tiket
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('ref_tiket_jenis');
    }
};
