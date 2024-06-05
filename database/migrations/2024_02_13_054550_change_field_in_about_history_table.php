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
        Schema::table('about_history', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->dropColumn('daftar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_history', function (Blueprint $table) {
            $table->string('daftar');

            $table->string('description')->nullable()->change();
        });
    }
};
