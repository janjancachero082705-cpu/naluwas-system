<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            if (!Schema::hasColumn('members', 'choir_group_id')) {
                $table->foreignId('choir_group_id')->nullable()->after('choir_role');
                $table->foreign('choir_group_id')->references('id')->on('choir_groups')->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropForeign(['choir_group_id']);
            $table->dropColumn('choir_group_id');
        });
    }
};