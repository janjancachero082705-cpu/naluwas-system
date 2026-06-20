<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();  // ← CHANGE: removed $string, added $table->
            $table->date('date');
            $table->time('time')->nullable();
            $table->string('location')->nullable();
            $table->enum('type', ['service', 'practice', 'event', 'meeting', 'study'])->default('event');
            $table->string('color')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->string('recurrence_pattern')->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
