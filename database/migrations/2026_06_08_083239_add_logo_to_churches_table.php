<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('churches', function (Blueprint $table) {
            if (!Schema::hasColumn('churches', 'logo')) {
                $table->string('logo')->nullable()->after('name');
            }
        });
    }

    public function down()
    {
        Schema::table('churches', function (Blueprint $table) {
            $table->dropColumn('logo');
        });
    }
};