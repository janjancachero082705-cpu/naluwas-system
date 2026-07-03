<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_church_id')->constrained('churches')->onDelete('cascade');
            $table->foreignId('receiver_church_id')->constrained('churches')->onDelete('cascade');
            $table->string('subject')->nullable();
            $table->text('body');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->boolean('is_archived')->default(false);
            $table->json('attachments')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['sender_church_id', 'receiver_church_id']);
            $table->index(['receiver_church_id', 'is_read']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
};