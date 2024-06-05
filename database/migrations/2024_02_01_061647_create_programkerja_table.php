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
        Schema::create('programkerja', function (Blueprint $table) {
            $table->id();
            $table->text('title_content')->nullable();
            $table->string('title');
            $table->text('description');
            $table->string('image')->nullable();
            // $table->boolean('status_image')->default(false);
            // $table->string('banner')->nullable();
            // $table->boolean('status_banner')->default(false);
            // $table->string('icon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programkerja');
    }
};
