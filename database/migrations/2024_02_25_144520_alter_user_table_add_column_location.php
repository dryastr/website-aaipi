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
            $table->unsignedBigInteger('ref_provinsi_id')->nullable()->after('status');
            $table->unsignedBigInteger('ref_kota_kab_id')->nullable()->after('ref_provinsi_id');

            $table->foreign('ref_provinsi_id')
                ->references('id')->on('ref_provinsi')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('ref_kota_kab_id')
                ->references('id')->on('ref_kota_kab')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
                'ref_provinsi_id',
                'ref_kota_kab_id',
            ]);
        });
    }
};
