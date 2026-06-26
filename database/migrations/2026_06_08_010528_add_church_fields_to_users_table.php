<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Only add the column, no foreign key constraint
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'church_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('church_id')->nullable()->after('email');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('church_id');
            });
        }
    }
};
