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
        Schema::create('cms_struktur_organisasi', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('jabatan');
            $table->string('jabatan_title');
            $table->string('desc_jabatan');
            $table->string('image');
            // Uncomment the following lines if you plan to use PDF fields
            // $table->string('title_pdf')->nullable();
            // $table->string('pdf')->nullable();
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
        Schema::dropIfExists('cms_struktur_organisasi');
    }
};
