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
        Schema::table('registrations', function (Blueprint $table) {
            $table->text('catatan')->nullable()->after('status_approval');
            $table->dateTime('rejected_at')->nullable()->after('approval_by_name');
            $table->integer('rejected_by')->nullable()->after('rejected_at');
            $table->string('rejected_by_name')->nullable()->after('rejected_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn([
                'catatan',
                'rejected_at',
                'rejected_by',
                'rejected_by_name'
            ]);
        });
    }
};
