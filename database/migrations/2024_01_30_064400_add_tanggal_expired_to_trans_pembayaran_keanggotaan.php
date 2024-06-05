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
        Schema::table('trans_pembayaran_keanggotaan', function (Blueprint $table) {
            $table->dateTime('tanggal_expired')->nullable()->after('tanggal_bayar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trans_pembayaran_keanggotaan', function (Blueprint $table) {
            //
        });
    }
};
