<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('members')) {
            Schema::table('members', function (Blueprint $table) {
                // Add all missing columns
                if (!Schema::hasColumn('members', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('id');
                }
                
                if (!Schema::hasColumn('members', 'is_deceased')) {
                    $table->boolean('is_deceased')->default(false)->after('is_active');
                }
                
                if (!Schema::hasColumn('members', 'is_choir')) {
                    $table->boolean('is_choir')->default(false)->after('is_deceased');
                }
                
                if (!Schema::hasColumn('members', 'voice_part')) {
                    $table->string('voice_part')->nullable()->after('is_choir');
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('members')) {
            Schema::table('members', function (Blueprint $table) {
                $columns = ['is_active', 'is_deceased', 'is_choir', 'voice_part'];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('members', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
