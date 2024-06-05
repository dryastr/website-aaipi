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
        Schema::create('about_history', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            // $table->string('title_banner')->nullable();
            // $table->string('image_banner')->nullable();
            $table->string('description')->nullable();
            $table->string('daftar');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_history');
    }
};
