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
        Schema::create('ebitda_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();

            $table->date('period_date')->nullable();
            $table->unsignedSmallInteger('year');
            $table->string('scenario'); 
            // target_tahunan, target_harian, plan_harian, aktual_harian

            $table->decimal('revenue', 20, 2)->default(0);
            $table->decimal('doc_variable', 20, 2)->default(0);
            $table->decimal('doc_fixed', 20, 2)->default(0);
            $table->decimal('ioc', 20, 2)->default(0);
            $table->decimal('toc', 20, 2)->default(0);
            $table->decimal('ebitda', 20, 2)->default(0);
            $table->decimal('ebitda_margin', 10, 4)->nullable();

            $table->timestamps();

            $table->unique(['organization_id', 'year', 'period_date', 'scenario'], 'ebitda_values_unique');
            $table->index(['year', 'scenario']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ebitda_values');
    }
};
