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
        Schema::table('sdm_kdkmp_entries', function (Blueprint $table) {
            $table->dropUnique(['nama_koperasi']);

            $table->string('nik')->nullable()->unique()->after('id');
            $table->string('nama_kodam')->nullable()->after('nama_koperasi');
            $table->string('nama_korem')->nullable()->after('nama_kodam');
            $table->string('nama_kodim')->nullable()->after('nama_korem');
            $table->string('desa')->nullable()->after('nama_kodim');
            $table->string('kecamatan')->nullable()->after('desa');
            $table->string('kota_kabupaten')->nullable()->after('kecamatan');
            $table->string('batch')->nullable()->after('kota_kabupaten');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sdm_kdkmp_entries', function (Blueprint $table) {
            $table->dropColumn([
                'nik',
                'nama_kodam',
                'nama_korem',
                'nama_kodim',
                'desa',
                'kecamatan',
                'kota_kabupaten',
                'batch',
            ]);

            $table->unique('nama_koperasi');
        });
    }
};
