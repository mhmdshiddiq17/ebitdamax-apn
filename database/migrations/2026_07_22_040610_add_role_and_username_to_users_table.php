<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')
                ->nullable()
                ->after('id')
                ->constrained('roles')
                ->nullOnDelete();
            $table->string('username')
                ->nullable()
                ->unique()
                ->after('name');

            $table->index('name');
        });

        $usedUsernames = [];

        DB::table('users')
            ->select(['id', 'name'])
            ->orderBy('id')
            ->get()
            ->each(function (object $user) use (&$usedUsernames): void {
                $baseUsername = Str::slug((string) $user->name) ?: Str::random(8);
                $username = $baseUsername;
                $suffix = 2;

                while (in_array($username, $usedUsernames, true)) {
                    $username = $baseUsername.'-'.$suffix;
                    $suffix++;
                }

                $usedUsernames[] = $username;

                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['username' => $username]);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropIndex(['name']);
            $table->dropColumn(['role_id', 'username']);
        });
    }
};
