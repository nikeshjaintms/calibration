<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('calibration_points', function (Blueprint $table) {
            $table->decimal('desired_output', 12, 4)->nullable()->after('set_point_percentage');
        });
    }

    public function down(): void
    {
        Schema::table('calibration_points', function (Blueprint $table) {
            $table->dropColumn('desired_output');
        });
    }
};
