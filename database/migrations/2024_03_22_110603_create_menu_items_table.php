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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('image')->default('images/restraunt/img.jpg');
            $table->double('price');
            $table->string('discount_days');
            $table->double('discount')->nullable();
            $table->date('discount_till_date')->nullable();
            $table->foreignId('menu_category_id');
            $table->foreign('menu_category_id')->references('id')->on('menu_categories');
            $table->foreignId('restraunt_id');
            $table->foreign('restraunt_id')->references('id')->on('restraunts');
            $table->boolean('available')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
