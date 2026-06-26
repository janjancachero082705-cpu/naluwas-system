<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Money transactions
        if (Schema::hasTable('money_transactions') && !Schema::hasColumn('money_transactions', 'church_id')) {
            Schema::table('money_transactions', function (Blueprint $table) {
                $table->unsignedBigInteger('church_id')->nullable()->after('id');
                $table->foreign('church_id')->references('id')->on('churches')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('money_transactions') && Schema::hasColumn('money_transactions', 'church_id')) {
            Schema::table('money_transactions', function (Blueprint $table) {
                $table->dropForeign(['church_id']);
                $table->dropColumn('church_id');
            });
        }
    }
};
