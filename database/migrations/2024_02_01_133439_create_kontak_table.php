<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations kontak.
     */
    public function up(): void
    {
        Schema::create('kontak', function (Blueprint $table) {
            $table->id();
            $table->string('title_content')->nullable();
            $table->string('title_banner')->nullable();
            $table->string('image_banner')->nullable();
            $table->string('title');
            $table->text('description');
            $table->string('icon');
            $table->string('kode')->nullable();
            $table->string('content')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontak');
    }
};
