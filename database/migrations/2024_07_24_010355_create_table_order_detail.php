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
        Schema::create('order_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity')->default(1);
            $table->integer('price');
            $table->text('note')->nullable();
            $table->boolean('priority')->default(0);
            $table->enum('accept', [0,1])->comment('0: Đã đặt, 1: Xác nhận món')->default(0);
            $table->enum('status', [0,1,2])->comment('0: Chờ nấu, 1: Xác nhận nấu, 2: Hoàn thành')->default(0);
            $table->foreignId('staff_id')->references('id')->on('users');
            $table->foreignId('order_id')->references('id')->on('orders');
            $table->foreignId('dish_id')->references('id')->on('dishs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};