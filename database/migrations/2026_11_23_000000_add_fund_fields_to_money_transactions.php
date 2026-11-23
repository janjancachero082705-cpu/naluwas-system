<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('money_transactions', function (Blueprint $table) {
            $table->string('fund', 20)->default('offering')->after('type');
            $table->text('purpose')->nullable()->after('recipient');
            $table->unsignedBigInteger('created_by')->nullable()->after('remarks');

            $table->index(['church_id', 'fund', 'date'], 'mt_church_fund_date_idx');
        });

        // Old rows categorised as Missions go to the Missions fund, everything else to Offering.
        DB::table('money_transactions')
            ->whereRaw('LOWER(category) = ?', ['missions'])
            ->update(['fund' => 'missions']);
    }

    public function down(): void
    {
        Schema::table('money_transactions', function (Blueprint $table) {
            $table->dropIndex('mt_church_fund_date_idx');
            $table->dropColumn(['fund', 'purpose', 'created_by']);
        });
    }
};