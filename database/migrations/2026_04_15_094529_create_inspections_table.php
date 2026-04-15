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
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jobcard_id')->constrained('jobcards')->onDelete('cascade');
            $table->enum('body_condition', ['ok', 'damage'])->default('ok');
            $table->enum('display_status', ['working', 'not_working'])->default('working');
            $table->enum('motherboard_status', ['ok', 'damage'])->default('ok');
            $table->enum('power_card_status', ['ok', 'damage'])->default('ok');
            $table->enum('sensor_status', ['ok', 'damage'])->default('ok');
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
