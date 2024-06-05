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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullname', 150)->index();
            $table->string('email')->unique();
            $table->string('mobile')->nullable();
            $table->integer('role_id')->unsigned();
            $table->string('avatar')->nullable();
            $table->string('email_verify_key')->index()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->enum('status', ['active', 'inactive'])->default('active');
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
        Schema::dropIfExists('users');
    }
};
