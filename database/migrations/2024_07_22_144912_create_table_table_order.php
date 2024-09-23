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
        Schema::create('table_order', function (Blueprint $table) {
            $table->id();
            $table->timestamp('order_date')->nullable();
            $table->enum('status', [0, 1, 2, 3])
                  ->comment('0: Đã đặt , 1: Quá giờ, 2: Khách hủy, 3: Đã lên món')
                  ->default(0);
            $table->foreignId('table_id')->references('id')->on('tables');
            $table->foreignId('customer_id')->references('id')->on('customers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table__orders');
    }
};