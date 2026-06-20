<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('money_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // income or expense
            $table->string('description');
            $table->string('category')->nullable();
            $table->decimal('amount', 12, 2);
            $table->date('date');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('money_transactions');
    }
};