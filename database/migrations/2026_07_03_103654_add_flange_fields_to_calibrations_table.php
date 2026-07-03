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
        Schema::table('calibrations', function (Blueprint $table) {
            $table->foreignId('flange_id')->nullable()->after('jobcard_id')->constrained('flanges')->onDelete('set null');
            $table->string('flange_size')->nullable()->after('flange_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calibrations', function (Blueprint $table) {
            $table->dropForeign(['flange_id']);
            $table->dropColumn(['flange_id', 'flange_size']);
        });
    }
};
