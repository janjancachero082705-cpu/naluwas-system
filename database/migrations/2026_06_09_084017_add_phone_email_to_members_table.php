<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneEmailToMembersTable extends Migration
{
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            if (!Schema::hasColumn('members', 'phone')) {
                $table->string('phone')->nullable()->after('address');
            }
            if (!Schema::hasColumn('members', 'email')) {
                $table->string('email')->nullable()->after('phone');
            }
        });
    }

    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['phone', 'email']);
        });
    }
}
