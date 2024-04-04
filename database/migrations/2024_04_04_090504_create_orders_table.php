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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('restraunt_id');
            $table->foreign('restraunt_id')->references('id')->on('restraunts')->onDelete('cascade');
            $table->foreignId('user_address_id');
            $table->foreign('user_address_id')->references('id')->on('user_addresses')->onDelete('cascade');
            $table->foreignId('driver_id')->nullable();
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
            $table->decimal('total_amount')->nullable();
            $table->integer('total_quantity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
