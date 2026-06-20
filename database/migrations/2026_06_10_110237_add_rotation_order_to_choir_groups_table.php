<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('choir_groups', function (Blueprint $table) {
            if (!Schema::hasColumn('choir_groups', 'rotation_order')) {
                $table->integer('rotation_order')->default(0)->after('display_order');
            }
        });
    }

    public function down()
    {
        Schema::table('choir_groups', function (Blueprint $table) {
            $table->dropColumn('rotation_order');
        });
    }
};