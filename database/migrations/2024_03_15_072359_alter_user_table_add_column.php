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
        Schema::table('users', function (Blueprint $table) {
            // Additional user details
            $table->string('gelar_depan', 150)->nullable()->after('mobile');
            $table->string('gelar_belakang', 150)->nullable()->after('gelar_depan');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Reverse the changes made in the "up" method
            $table->dropColumn([
                'name_gelar',
            ]);
        });
    }
};
