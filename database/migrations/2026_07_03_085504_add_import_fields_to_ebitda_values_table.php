<?php

use App\Models\ExcelImport;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ebitda_values', function (Blueprint $table) {
            $table->foreignIdFor(ExcelImport::class)
                ->nullable()
                ->after('id')
                ->constrained()
                ->nullOnDelete();

            $table->string('source_sheet')->nullable()->after('scenario');
            $table->json('raw_payload')->nullable()->after('ebitda_margin');
        });
    }

    public function down(): void
    {
        Schema::table('ebitda_values', function (Blueprint $table) {
            $table->dropConstrainedForeignId('excel_import_id');
            $table->dropColumn(['source_sheet', 'raw_payload']);
        });
    }
};