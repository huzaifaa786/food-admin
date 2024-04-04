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
        Schema::create('order_item_extras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id');
            $table->foreign('order_item_id')->references('id')->on('order_items')->onDelete('cascade');
            $table->foreignId('extra_id');
            $table->foreign('extra_id')->references('id')->on('extras')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item_extras');
    }
};
