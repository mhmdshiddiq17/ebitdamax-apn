<?php

use App\Models\ExcelImport;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organization_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('organization_id')
                ->unique()
                ->constrained('organizations')
                ->cascadeOnDelete();

            $table->foreignIdFor(ExcelImport::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('source_sheet')->nullable();

            $table->longText('job_description')->nullable();
            $table->longText('qualification')->nullable();
            $table->longText('value_chain')->nullable();

            $table->decimal('method_cost', 20, 2)->nullable();

            $table->json('raw_payload')->nullable();

            $table->timestamps();

            $table->index('source_sheet');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organization_profiles');
    }
};
