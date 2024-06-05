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
        Schema::create('params_websites', function (Blueprint $table) {
            $table->id();
            $table->string('module')->nullable();
            $table->string('kode')->nullable();
            $table->enum('type', ['single', 'group'])->default('single');
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->text('image')->nullable();
            $table->string('icon')->nullable();
            $table->string('order_params')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('params_websites');
    }
};
