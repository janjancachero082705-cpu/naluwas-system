<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // First, change the column type to string para unlimited roles
        Schema::table('members', function (Blueprint $table) {
            // Change enum to string para maka-add ug any role
            $table->string('role')->default('member')->change();
        });
    }

    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            // Revert back to enum if needed
            $table->enum('role', ['member', 'choir', 'pastor', 'palagbulig'])->default('member')->change();
        });
    }
};