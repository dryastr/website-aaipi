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
        Schema::table('programkerja', function (Blueprint $table) {
            $table->boolean('status_image')->default(false)->after('image');
            $table->string('banner')->default('')->after('status_image');
            $table->boolean('status_banner')->default(false)->after('banner');
            $table->string('icon')->default('')->after('status_banner');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programkerja', function (Blueprint $table) {
            //
        });
    }
};
