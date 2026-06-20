<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'church_id')) {
                $table->foreignId('church_id')->nullable()->constrained()->onDelete('set null');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['super_admin', 'church_admin', 'staff', 'member'])->default('member');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['church_id']);
            $table->dropColumn(['church_id', 'role']);
        });
    }
};