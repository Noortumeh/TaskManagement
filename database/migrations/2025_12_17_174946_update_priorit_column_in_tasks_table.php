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
        Schema::table('tasks', function (Blueprint $table) {
            if (! Schema::hasColumn('tasks', 'priority_new') && Schema::hasColumn('tasks', 'priority')) {
                $table->enum('priority_new', ['high', 'medium', 'low'])
                    ->after('priority');
            }
        });

        // Migrate data from old priority column to new priority column
        if (Schema::hasColumn('tasks', 'priority')) {
            DB::table('tasks')->update([
                'priority_new' => DB::raw("CASE
                WHEN priority >= 4 THEN 'high'
                WHEN priority >=2 THEN 'medium'
                ELSE 'low'
            END"),
            ]);

            Schema::table('tasks', function (Blueprint $table) {
                $table->dropColumn('priority');
            });
        }

        Schema::table('tasks', function (Blueprint $table) {
            if (
                Schema::hasColumn('tasks', 'priority_new') &&
                ! Schema::hasColumn('tasks', 'priority')
            ) {
                $table->renameColumn('priority_new', 'priority');
            }
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->integer('priority_old')->default(0)->after('priority');
        });
        // Migrate data back from enum priority to integer priority
        DB::table('tasks')->update([
            'priority_old' => DB::raw("CASE
                WHEN priority = 'high' THEN 5
                WHEN priority = 'medium' THEN 3
                ELSE 1
            END"),
        ]);
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('priority');
            $table->renameColumn('priority_old', 'priority');
        });
    }
};
