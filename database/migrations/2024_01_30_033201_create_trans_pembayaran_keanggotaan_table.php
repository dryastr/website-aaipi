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
        Schema::create('trans_pembayaran_keanggotaan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('tagihan_id')->nullable()->index();
            $table->decimal('tagihan', 12, 2)->nullable()->index();
            $table->decimal('nominal_bayar', 12, 2)->nullable()->index();
            $table->enum('status', ['verifikasi-pembayaran', 'terverifikasi', 'ditolak'])->default('verifikasi-pembayaran');
            $table->text('catatan')->nullable();
            $table->dateTime('tanggal_bayar')->nullable();
            $table->dateTime('approval_at')->nullable();
            $table->integer('approval_by')->nullable();
            $table->string('approval_by_name')->nullable();
            $table->dateTime('rejected_at')->nullable();
            $table->integer('rejected_by')->nullable();
            $table->string('rejected_by_name')->nullable();
            $table->integer('created_by')->nullable();
            $table->string('created_by_name')->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('updated_by_name')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('tagihan_id')
                ->references('id')->on('ref_biaya_keanggotaan')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans_pembayaran_keanggotaan');
    }
};
