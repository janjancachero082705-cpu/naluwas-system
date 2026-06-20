<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChoirPracticeAttendancesTable extends Migration
{
    public function up()
    {
        Schema::create('choir_practice_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('choir_practice_id')->constrained()->onDelete('cascade');
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['Present', 'Absent', 'Late', 'Excused']);
            $table->text('notes')->nullable();
            $table->foreignId('marked_by')->nullable()->constrained('users');
            $table->datetime('marked_at')->nullable();
            $table->timestamps();
            
            $table->unique(['choir_practice_id', 'member_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('choir_practice_attendances');
    }
}