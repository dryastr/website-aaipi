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
        Schema::create('ref_biaya_keanggotaan', function (Blueprint $table) {
            $table->id();
            $table->decimal('biaya', 12, 2)->index();
            $table->integer('tahun')->index();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('jenis_keanggotaan', ['anggota-biasa', 'anggota-luar-biasa', 'anggota-kehormatan'])->nullable();
            $table->integer('created_by')->nullable();
            $table->string('created_by_name')->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('updated_by_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_biaya_keanggotaan');
    }
};
