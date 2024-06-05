<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ref_syarat_pendaftaran', function (Blueprint $table) {
            DB::statement("ALTER TABLE ref_syarat_pendaftaran MODIFY COLUMN type ENUM('text', 'file', 'checklist') DEFAULT 'text'");
            $table->text('requirment_filed')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ref_syarat_pendaftaran', function (Blueprint $table) {
            //
        });
    }
};
