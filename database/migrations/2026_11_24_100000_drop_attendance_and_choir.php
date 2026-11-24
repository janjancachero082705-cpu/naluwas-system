<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        foreach (['attendances', 'sunday_attendances', 'choir_practices', 'choir_schedules', 'choir_members', 'choir_groups'] as $t) {
            Schema::dropIfExists($t);
        }

        foreach (['is_choir', 'choir_role', 'choir_group_id', 'voice_part'] as $col) {
            if (Schema::hasColumn('members', $col)) {
                Schema::table('members', function (Blueprint $table) use ($col) {
                    $table->dropColumn($col);
                });
            }
        }
    }

    public function down(): void
    {
    }
};