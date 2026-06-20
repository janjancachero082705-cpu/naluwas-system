<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Drop existing tables
        Schema::dropIfExists('choir_schedule_member');
        Schema::dropIfExists('choir_schedules');
        
        // Create fresh choir_schedules table (SIMPLE - no group_id)
        Schema::create('choir_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained()->onDelete('cascade');
            $table->date('service_date');
            $table->timestamps();
            
            $table->unique(['church_id', 'service_date']);
        });
        
        // Create pivot table for members
        Schema::create('choir_schedule_member', function (Blueprint $table) {
            $table->id();
            $table->foreignId('choir_schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['choir_schedule_id', 'member_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('choir_schedule_member');
        Schema::dropIfExists('choir_schedules');
    }
};