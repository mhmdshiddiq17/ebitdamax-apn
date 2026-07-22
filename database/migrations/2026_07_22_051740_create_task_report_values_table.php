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
        Schema::create('task_report_values', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('task_report_id')->constrained('task_reports')->cascadeOnDelete();
            $table->foreignId('task_additional_field_id')->constrained('task_additional_fields')->cascadeOnDelete();
            $table->longText('value')->nullable();
            $table->timestamps();

            $table->unique(['task_report_id', 'task_additional_field_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_report_values');
    }
};
