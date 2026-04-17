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
        Schema::create('calibrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('jobcard_id')->constrained('jobcards')->onDelete('cascade');
            $table->string('calibration_by');
            $table->date('date');
            $table->string('instrument');
            $table->string('certificate_number');
            $table->string('temperature');
            $table->string('humidity');
            $table->enum('result', ['pass', 'fail'])->default('pass');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calibrations');
    }
};
