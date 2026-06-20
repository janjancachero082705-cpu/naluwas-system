<?php
// database/migrations/YYYY_MM_DD_HHMMSS_create_choir_groups_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChoirGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('choir_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('color')->default('#8b5cf6');
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['church_id', 'is_active']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('choir_groups');
    }
}