<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            if (!Schema::hasColumn('members', 'choir_role')) {
                $table->enum('choir_role', ['Singer', 'Guitarist', 'Bassist', 'Drummer'])->nullable()->after('is_choir');
            }
        });
    }

    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('choir_role');
        });
    }
};