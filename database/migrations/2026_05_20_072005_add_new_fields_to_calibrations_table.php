<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('calibrations', function (Blueprint $table) {
            $table->string('po_no')->nullable();
            $table->date('po_date')->nullable();
            $table->string('warranty')->nullable()->default('12 MONTHS');
            $table->date('warranty_due_date')->nullable();
            $table->string('pressure_unit')->nullable()->default('MMWC');
            $table->string('master_accuracy')->nullable()->default('\pm 0.0003%');
            $table->string('calibration_method')->nullable()->default('Compression');
            $table->string('communicator_make')->nullable()->default('Prisys (Brazil), SKE, Automac, Siemens');
            $table->string('activity')->nullable()->default("Transmitter Health check, '0' set, Range setting, Linearity check, Output check");
            $table->text('work_details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calibrations', function (Blueprint $table) {
            $table->dropColumn([
                'po_no',
                'po_date',
                'warranty',
                'warranty_due_date',
                'pressure_unit',
                'master_accuracy',
                'calibration_method',
                'communicator_make',
                'activity',
                'work_details',
            ]);
        });
    }
};
