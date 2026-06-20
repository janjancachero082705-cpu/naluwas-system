<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('category');
            $table->integer('quantity')->default(0);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->integer('reorder_level')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};