<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
            $table->unsignedTinyInteger('depth')->default(0)->after('parent_id');
            $table->string('path')->nullable()->index()->after('depth');
            $table->string('node_type')->nullable()->after('level');
            $table->boolean('is_active')->default(true)->after('is_cost_center');
        });
    }

    public function down(): void
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn([
                'slug',
                'depth',
                'path',
                'node_type',
                'is_active',
            ]);
        });
    }
};