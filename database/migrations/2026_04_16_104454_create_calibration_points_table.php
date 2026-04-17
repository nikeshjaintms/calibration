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
        Schema::create('calibration_points', function (Blueprint $table) {
            $table->id();
             $table->foreignId('calibration_id')
                  ->constrained('calibrations')
                  ->cascadeOnDelete();

            // Expected value (auto-generated from range)
            $table->decimal('expected', 12, 2);

            // User inputs
            $table->decimal('as_found', 12, 2)->nullable();
            $table->decimal('as_left', 12, 2)->nullable();

            // Auto-calculated fields
            $table->decimal('error', 12, 2)->nullable();
            $table->decimal('error_percentage', 12, 4)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calibration_points');
    }
};
