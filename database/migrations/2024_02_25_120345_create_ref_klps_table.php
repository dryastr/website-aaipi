<?php

use App\Helpers\Enums\Klp\Jenis;
use App\Helpers\Enums\Klp\Level;
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
        Schema::create('ref_klps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('parent_root_id')->nullable();
            $table->unsignedBigInteger('ref_provinsi_id')->nullable();
            $table->unsignedBigInteger('ref_kota_kab_id')->nullable();
            $table->string('kode', 50);
            $table->string('nama', 200);
            $table->string('nama_pendek', 50);
            $table->enum('jenis', Jenis::toArray());
            $table->enum('level', Level::toArray());
            $table->text('attrs')->nullable();
            $table->string('pimpinan', 100)->nullable();
            $table->string('jabatan_pimpinan', 100)->nullable();
            $table->string('logo')->nullable();
            $table->string('no_telp', 50)->nullable();
            $table->string('website', 50)->nullable();
            $table->string('fax', 50)->nullable();
            $table->text('alamat')->nullable();
            $table->boolean('is_active')->default(false);
            $table->integer('created_by')->nullable();
            $table->string('created_by_name')->nullable();
            $table->integer('updated_by')->nullable();
            $table->string('updated_by_name')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('ref_klps');
    }
};
