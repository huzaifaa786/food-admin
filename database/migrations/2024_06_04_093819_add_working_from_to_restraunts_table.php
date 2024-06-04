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
        Schema::table('restraunts', function (Blueprint $table) {
            $table->bigInteger('working_from')->nullable();
            $table->bigInteger('working_to')->nullable();
            $table->bigInteger('delivery_charges')->nullable();
            $table->bigInteger('minimum_charges')->nullable();
            $table->bigInteger('delivery_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restraunts', function (Blueprint $table) {
            //
        });
    }
};
