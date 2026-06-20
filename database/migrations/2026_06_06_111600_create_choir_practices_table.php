<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Check if table doesn't exist before creating
        if (!Schema::hasTable('choir_practices')) {
            Schema::create('choir_practices', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('church_id');
                $table->string('title');
                $table->text('description')->nullable();
                $table->date('date');
                $table->time('start_time');
                $table->time('end_time')->nullable();
                $table->string('location')->nullable();
                $table->timestamps();
                
                $table->index('church_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('choir_practices');
    }
};