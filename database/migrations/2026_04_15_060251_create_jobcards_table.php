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
    Schema::create('jobcards', function (Blueprint $table) {
        $table->id();
        // Foreign key
        $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
        
        // Form details
        $table->string('jobcard_number')->unique();
        $table->date('jobcard_date');
        $table->date('reciving_date');
        $table->string('customer_name');
        $table->string('tag_no');
        $table->string('model_no');
        $table->string('serial_no');
        $table->string('start_range');
        $table->string('end_range');

        // Status fields
        $table->enum('body_condition', ['ok', 'damage'])->default('ok');
        $table->enum('display_status', ['working', 'not_working'])->default('working');
        $table->enum('motherboard_status', ['ok', 'damage'])->default('ok');
        $table->enum('power_card_status', ['ok', 'damage'])->default('ok');
        $table->enum('sensor_status', ['ok', 'damage'])->default('ok');
        
        // ફક્ત એક જ વાર status રાખવું
        $table->enum('status', ['active', 'inactive'])->default('active'); 

        $table->timestamps();
        $table->softDeletes();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobcards');
    }
};
