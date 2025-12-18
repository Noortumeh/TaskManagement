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
        if (
            Schema::hasColumn('tasks', 'priority_new') &&
            ! Schema::hasColumn('tasks', 'priority')
        ) {
            DB::statement("
            ALTER TABLE tasks
            CHANGE priority_new priority
            ENUM('high','medium','low')
            NOT NULL DEFAULT 'medium'
        ");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->renameColumn('priority', 'priority_new');
        });
    }
};
