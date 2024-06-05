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
        Schema::create('ref_kota_kab', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ref_provinsi_id')->nullable();
            $table->string('kode', 50)->nullable();
            $table->string('nama')->nullable();
            $table->boolean('is_active')->default(false);
            $table->integer('created_by')->nullable();
            $table->string('created_by_name')->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('updated_by_name')->nullable();
            $table->timestamps();

            $table->foreign('ref_provinsi_id')
                ->references('id')->on('ref_provinsi')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_kota_kab');
    }
};
