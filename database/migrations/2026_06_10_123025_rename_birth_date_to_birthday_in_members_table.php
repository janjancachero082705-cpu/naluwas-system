<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            if (Schema::hasColumn('members', 'birth_date') && !Schema::hasColumn('members', 'birthday')) {
                $table->renameColumn('birth_date', 'birthday');
            }
        });
    }

    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            if (Schema::hasColumn('members', 'birthday') && !Schema::hasColumn('members', 'birth_date')) {
                $table->renameColumn('birthday', 'birth_date');
            }
        });
    }
};