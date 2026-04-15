<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Move data to inspections table
        $jobcards = DB::table('jobcards')->get();
        foreach ($jobcards as $jobcard) {
            DB::table('inspections')->insert([
                'jobcard_id' => $jobcard->id,
                'body_condition' => $jobcard->body_condition,
                'display_status' => $jobcard->display_status,
                'motherboard_status' => $jobcard->motherboard_status,
                'power_card_status' => $jobcard->power_card_status,
                'sensor_status' => $jobcard->sensor_status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::table('jobcards', function (Blueprint $table) {
            $table->dropColumn([
                'body_condition',
                'display_status',
                'motherboard_status',
                'power_card_status',
                'sensor_status'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobcards', function (Blueprint $table) {
            $table->enum('body_condition', ['ok', 'damage'])->default('ok');
            $table->enum('display_status', ['working', 'not_working'])->default('working');
            $table->enum('motherboard_status', ['ok', 'damage'])->default('ok');
            $table->enum('power_card_status', ['ok', 'damage'])->default('ok');
            $table->enum('sensor_status', ['ok', 'damage'])->default('ok');
        });
    }
};
