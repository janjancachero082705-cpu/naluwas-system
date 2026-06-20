<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Check if column exists first
        if (!Schema::hasColumn('choir_schedules', 'group_id')) {
            Schema::table('choir_schedules', function (Blueprint $table) {
                $table->unsignedBigInteger('group_id')->nullable()->after('service_date');
                $table->foreign('group_id')->references('id')->on('choir_groups')->onDelete('set null');
            });
        }
    }

    public function down()
    {
        Schema::table('choir_schedules', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropColumn('group_id');
        });
    }
};