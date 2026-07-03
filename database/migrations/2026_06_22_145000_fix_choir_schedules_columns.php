<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('choir_schedules')) {
            return;
        }
        
        // Drop the problematic foreign key
        try {
            DB::statement('ALTER TABLE choir_schedules DROP FOREIGN KEY choir_schedules_church_id_foreign');
        } catch (\Exception $e) {
            // Foreign key doesn't exist, continue
        }
        
        Schema::table('choir_schedules', function (Blueprint $table) {
            // Add church_id if it doesn't exist
            if (!Schema::hasColumn('choir_schedules', 'church_id')) {
                $table->unsignedBigInteger('church_id')->nullable();
            }
            
            // Add member_id if it doesn't exist
            if (!Schema::hasColumn('choir_schedules', 'member_id')) {
                $table->unsignedBigInteger('member_id')->nullable();
            }
            
            // Add foreign keys - but only if they don't already exist
            if (Schema::hasColumn('choir_schedules', 'church_id') && Schema::hasTable('churches')) {
                try {
                    $table->foreign('church_id')
                          ->references('id')
                          ->on('churches')
                          ->onDelete('cascade');
                } catch (\Exception $e) {
                    // Foreign key already exists, skip
                }
            }
            
            if (Schema::hasColumn('choir_schedules', 'member_id') && Schema::hasTable('members')) {
                try {
                    $table->foreign('member_id')
                          ->references('id')
                          ->on('members')
                          ->onDelete('cascade');
                } catch (\Exception $e) {
                    // Foreign key already exists, skip
                }
            }
        });
    }

    public function down()
    {
        if (!Schema::hasTable('choir_schedules')) {
            return;
        }
        
        Schema::table('choir_schedules', function (Blueprint $table) {
            try {
                $table->dropForeign(['church_id']);
            } catch (\Exception $e) {}
            
            try {
                $table->dropForeign(['member_id']);
            } catch (\Exception $e) {}
            
            if (Schema::hasColumn('choir_schedules', 'church_id')) {
                $table->dropColumn('church_id');
            }
            
            if (Schema::hasColumn('choir_schedules', 'member_id')) {
                $table->dropColumn('member_id');
            }
        });
    }
};