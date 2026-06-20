<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            if (!Schema::hasColumn('members', 'is_deceased')) {
                $table->boolean('is_deceased')->default(false);
            }
            if (!Schema::hasColumn('members', 'date_deceased')) {
                $table->date('date_deceased')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['is_deceased', 'date_deceased']);
        });
    }
};