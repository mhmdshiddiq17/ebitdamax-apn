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
        Schema::create('import_error_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('excel_import_id')->constrained('excel_imports')->cascadeOnDelete();
            $table->unsignedInteger('row_number')->nullable();
            $table->string('sheet_name')->nullable();
            $table->text('message');
            $table->json('payload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_error_logs');
    }
};
