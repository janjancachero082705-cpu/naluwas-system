<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            if (Schema::hasColumn('members', 'email')) {
                $table->dropColumn('email');
            }
            if (Schema::hasColumn('members', 'phone')) {
                $table->dropColumn('phone');
            }
        });
    }

    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
        });
    }
};