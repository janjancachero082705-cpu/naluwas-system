<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('money_transactions', function (Blueprint $table) {
            // Add recipient column for expenses
            if (!Schema::hasColumn('money_transactions', 'recipient')) {
                $table->string('recipient')->nullable()->after('amount');
            }
            // Add donor_name column for income
            if (!Schema::hasColumn('money_transactions', 'donor_name')) {
                $table->string('donor_name')->nullable()->after('amount');
            }
        });
    }

    public function down()
    {
        Schema::table('money_transactions', function (Blueprint $table) {
            $table->dropColumn(['recipient', 'donor_name']);
        });
    }
};