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
        Schema::create('membership_poins', function (Blueprint $table) {
            $table->id('membership_poin_id');
            $table->integer('customer_id');
            $table->integer('transaction_id');
            $table->integer('poin_earned');
            $table->integer('poin_redeemed');
            $table->integer('balance');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_poins');
    }
};
