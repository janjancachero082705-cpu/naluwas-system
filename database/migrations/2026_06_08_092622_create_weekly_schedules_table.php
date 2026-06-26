<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('weekly_schedules', function (Blueprint $table) {
            $table->id();
            
            // Church relationship (for multi-church support)
            $table->foreignId('church_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            // Day of the week
            $table->enum('day', [
                'monday', 
                'tuesday', 
                'wednesday', 
                'thursday', 
                'friday', 
                'saturday', 
                'sunday'
            ]);
            
            // Time fields
            $table->time('start_time');
            $table->time('end_time');
            
            // Activity type
            $table->enum('type', [
                'choir',           // Choir Practice
                'bible_study',     // Bible Study
                'prayer_meeting',  // Prayer Meeting
                'youth_fellowship',// Youth Fellowship
                'children_church'  // Children's Church
            ]);
            
            // Status
            $table->boolean('is_active')->default(true);
            
            // Timestamps
            $table->timestamps();
            
            // Indexes for faster queries
            $table->index(['church_id', 'day']);
            $table->index(['church_id', 'is_active']);
            
            // Unique constraint to prevent duplicate schedules
            $table->unique(['church_id', 'day', 'type'], 'unique_church_day_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_schedules');
    }
};
