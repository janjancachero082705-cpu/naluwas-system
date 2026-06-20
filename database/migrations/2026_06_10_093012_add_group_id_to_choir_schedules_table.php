<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('choir_schedules', function (Blueprint $table) {
            if (!Schema::hasColumn('choir_schedules', 'group_id')) {
                $table->unsignedBigInteger('group_id')->nullable();
                $table->foreign('group_id')->references('id')->on('choir_groups')->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('choir_schedules', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropColumn('group_id');
        });
    }
};