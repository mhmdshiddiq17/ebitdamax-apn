<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('task_roles')) {
            Schema::create('task_roles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('task_id')->constrained('tasks')->cascadeOnDelete();
                $table->foreignId('role_id')->constrained('roles')->restrictOnDelete();
                $table->timestamps();

                $table->unique(['task_id', 'role_id']);
                $table->index(['role_id', 'task_id']);
            });
        }

        if (Schema::hasColumn('tasks', 'role_id')) {
            DB::statement(<<<'SQL'
                insert into task_roles (task_id, role_id, created_at, updated_at)
                select id, role_id, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
                from tasks
                where role_id is not null
                on conflict (task_id, role_id) do nothing
            SQL);
        }

        Schema::table('tasks', function (Blueprint $table) {
            if (! Schema::hasColumn('tasks', 'period')) {
                $table->string('period')->default('once')->after('time_require');
                $table->index('period');
            }
        });

        Schema::table('task_reports', function (Blueprint $table) {
            if (! Schema::hasColumn('task_reports', 'period_key')) {
                $table->string('period_key')->nullable()->after('user_id');
                $table->index(['task_id', 'user_id', 'period_key', 'status']);
            }
        });

        if (Schema::hasColumn('task_reports', 'period_key')) {
            DB::table('task_reports')
                ->whereNull('period_key')
                ->update(['period_key' => 'once']);
        }

        if (Schema::hasColumn('tasks', 'role_id')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->dropConstrainedForeignId('role_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            if (! Schema::hasColumn('tasks', 'role_id')) {
                $table->foreignId('role_id')
                    ->nullable()
                    ->after('task_category_id')
                    ->constrained('roles')
                    ->restrictOnDelete();
            }
        });

        if (Schema::hasTable('task_roles') && Schema::hasColumn('tasks', 'role_id')) {
            DB::statement(<<<'SQL'
                update tasks
                set role_id = selected_roles.role_id
                from (
                    select distinct on (task_id) task_id, role_id
                    from task_roles
                    order by task_id, role_id
                ) as selected_roles
                where tasks.id = selected_roles.task_id
            SQL);
        }

        Schema::table('task_reports', function (Blueprint $table) {
            if (Schema::hasColumn('task_reports', 'period_key')) {
                $table->dropIndex(['task_id', 'user_id', 'period_key', 'status']);
                $table->dropColumn('period_key');
            }
        });

        Schema::table('tasks', function (Blueprint $table) {
            if (Schema::hasColumn('tasks', 'period')) {
                $table->dropIndex(['period']);
                $table->dropColumn('period');
            }
        });

        Schema::dropIfExists('task_roles');
    }
};
