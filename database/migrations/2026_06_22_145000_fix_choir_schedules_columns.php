<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('choir_schedules')) {
            Schema::table('choir_schedules', function (Blueprint $table) {
                // Add member_id if it doesn't exist
                if (!Schema::hasColumn('choir_schedules', 'member_id')) {
                    $table->unsignedBigInteger('member_id')->nullable()->after('id');
                }
                
                // Add church_id if it doesn't exist
                if (!Schema::hasColumn('choir_schedules', 'church_id')) {
                    $table->unsignedBigInteger('church_id')->nullable()->after('member_id');
                }
                
                // Add foreign keys
                if (Schema::hasColumn('choir_schedules', 'member_id')) {
                    try {
                        $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
                    } catch (\Exception $e) {
                        // Foreign key might already exist
                    }
                }
                
                if (Schema::hasColumn('choir_schedules', 'church_id')) {
                    try {
                        $table->foreign('church_id')->references('id')->on('churches')->onDelete('cascade');
                    } catch (\Exception $e) {
                        // Foreign key might already exist
                    }
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('choir_schedules')) {
            Schema::table('choir_schedules', function (Blueprint $table) {
                if (Schema::hasColumn('choir_schedules', 'member_id')) {
                    $table->dropForeign(['member_id']);
                    $table->dropColumn('member_id');
                }
                if (Schema::hasColumn('choir_schedules', 'church_id')) {
                    $table->dropForeign(['church_id']);
                    $table->dropColumn('church_id');
                }
            });
        }
    }
};
