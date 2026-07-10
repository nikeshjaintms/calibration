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
        Schema::table('oil_fillings', function (Blueprint $table) {
            $table->string('moc_size')->nullable()->after('moc_id');
            $table->string('flange_size')->nullable()->after('flange_id');
            $table->string('capillary_size')->nullable()->after('capillary_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('oil_fillings', function (Blueprint $table) {
            $table->dropColumn(['moc_size', 'flange_size', 'capillary_size']);
        });
    }
};
