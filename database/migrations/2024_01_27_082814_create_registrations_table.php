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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->index()->unique();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('no_telp', 50)->nullable();
            $table->string('nama_instansi')->nullable();
            $table->string('jabatan', 50)->nullable();
            $table->text('alamat')->nullable();
            $table->enum('status_approval', ['dalam-antrian', 'disetujui', 'ditolak'])->default('dalam-antrian');
            $table->dateTime('approval_at')->nullable();
            $table->integer('approval_by')->nullable();
            $table->string('approval_by_name')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
