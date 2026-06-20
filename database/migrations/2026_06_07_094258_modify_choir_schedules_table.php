<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('choir_schedules', function (Blueprint $table) {
            // Add choir_role column if it doesn't exist
            if (!Schema::hasColumn('choir_schedules', 'choir_role')) {
                $table->enum('choir_role', ['Singer', 'Guitarist', 'Bassist', 'Drummer'])->nullable()->after('role');
            }
            
            // Drop voice_part column if it exists
            if (Schema::hasColumn('choir_schedules', 'voice_part')) {
                $table->dropColumn('voice_part');
            }
        });
    }

    public function down()
    {
        Schema::table('choir_schedules', function (Blueprint $table) {
            if (Schema::hasColumn('choir_schedules', 'choir_role')) {
                $table->dropColumn('choir_role');
            }
            if (!Schema::hasColumn('choir_schedules', 'voice_part')) {
                $table->string('voice_part')->nullable();
            }
        });
    }
};