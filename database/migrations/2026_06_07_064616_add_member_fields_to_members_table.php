<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            // Check if columns exist before adding
            if (!Schema::hasColumn('members', 'first_name')) {
                $table->string('first_name')->after('id');
            }
            
            if (!Schema::hasColumn('members', 'last_name')) {
                $table->string('last_name')->after('first_name');
            }
            
            if (!Schema::hasColumn('members', 'birthday')) {
                $table->date('birthday')->nullable()->after('last_name');
            }
            
            if (!Schema::hasColumn('members', 'address')) {
                $table->text('address')->nullable()->after('birthday');
            }
            
            if (!Schema::hasColumn('members', 'is_choir')) {
                $table->boolean('is_choir')->default(false)->after('address');
            }
        });
    }

    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name', 
                'birthday',
                'address',
                'is_choir'
            ]);
        });
    }
};