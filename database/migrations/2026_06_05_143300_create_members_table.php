<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('church_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birthday')->nullable();
            $table->text('address')->nullable();
            $table->string('role')->default('member');
            $table->timestamps();
            
            // Remove foreign key - just add index
            $table->index('church_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};