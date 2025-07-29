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
            $table->string('stripe_account_id')->nullable();
            $table->string('onboarding_status')->default('not_started');
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
