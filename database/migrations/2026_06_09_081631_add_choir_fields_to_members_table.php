<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChoirFieldsToMembersTable extends Migration
{
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            if (!Schema::hasColumn('members', 'voice_part')) {
                $table->string('voice_part')->nullable()->after('is_choir');
            }
            if (!Schema::hasColumn('members', 'choir_role')) {
                $table->string('choir_role')->nullable()->after('voice_part');
            }
        });
    }

    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['voice_part', 'choir_role']);
        });
    }
}
