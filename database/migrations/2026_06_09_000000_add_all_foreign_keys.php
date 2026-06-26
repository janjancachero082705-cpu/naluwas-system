<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Only add foreign keys if churches table exists
        if (!Schema::hasTable('churches')) {
            return;
        }

        // Users table
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'church_id')) {
            try {
                Schema::table('users', function (Blueprint $table) {
                    $table->foreign('church_id')->references('id')->on('churches')->onDelete('set null');
                });
            } catch (\Exception $e) {
                // Foreign key might already exist
            }
        }

        // Weekly schedules table
        if (Schema::hasTable('weekly_schedules') && Schema::hasColumn('weekly_schedules', 'church_id')) {
            try {
                Schema::table('weekly_schedules', function (Blueprint $table) {
                    $table->foreign('church_id')->references('id')->on('churches')->onDelete('cascade');
                });
            } catch (\Exception $e) {
                // Foreign key might already exist
            }
        }

        // Money transactions table
        if (Schema::hasTable('money_transactions') && Schema::hasColumn('money_transactions', 'church_id')) {
            try {
                Schema::table('money_transactions', function (Blueprint $table) {
                    $table->foreign('church_id')->references('id')->on('churches')->onDelete('cascade');
                });
            } catch (\Exception $e) {
                // Foreign key might already exist
            }
        }

        // Choir practices table
        if (Schema::hasTable('choir_practices') && Schema::hasColumn('choir_practices', 'church_id')) {
            try {
                Schema::table('choir_practices', function (Blueprint $table) {
                    $table->foreign('church_id')->references('id')->on('churches')->onDelete('cascade');
                });
            } catch (\Exception $e) {
                // Foreign key might already exist
            }
        }

        // Church settings table
        if (Schema::hasTable('church_settings') && Schema::hasColumn('church_settings', 'church_id')) {
            try {
                Schema::table('church_settings', function (Blueprint $table) {
                    $table->foreign('church_id')->references('id')->on('churches')->onDelete('cascade');
                });
            } catch (\Exception $e) {
                // Foreign key might already exist
            }
        }
    }

    public function down()
    {
        $tables = ['users', 'weekly_schedules', 'money_transactions', 'choir_practices', 'church_settings'];
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                try {
                    Schema::table($table, function (Blueprint $table) {
                        $table->dropForeign(['church_id']);
                    });
                } catch (\Exception $e) {
                    // Foreign key might not exist
                }
            }
        }
    }
};
