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
        Schema::create('dishs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('original_price');
            $table->string('thumbnail')->nullable();
            $table->text('note')->nullable();
            $table->enum('status', [0, 1])->comment('0: Sẳn sàng, 1: Đã hết')->default(0);
            $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dishs');
    }
};