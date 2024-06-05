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
        Schema::table('category_on_galeri', function (Blueprint $table) {
            if (!Schema::hasColumn('category_on_galeri', 'date')) {
                $table->date('date')->nullable()->after('title');
            }
            if (!Schema::hasColumn('category_on_galeri', 'location')) {
                $table->string('location')->nullable()->after('date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
