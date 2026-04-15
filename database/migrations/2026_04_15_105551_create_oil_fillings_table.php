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
        Schema::create('oil_fillings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jobcard_id')->constrained('jobcards')->onDelete('cascade');
            $table->string('oil_type')->default('DC705');
            $table->string('quantity');
            $table->date('filling_date');
            $table->foreignId('moc_id')->constrained('m_o_c_s')->onDelete('cascade');
            $table->foreignId('flange_id')->constrained('flanges')->onDelete('cascade');
            $table->foreignId('capillary_id')->constrained('capillaries')->onDelete('cascade');
            $table->string('filled_by')->default('DILIPBHAI PATEL');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oil_fillings');
    }
};
