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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->integer('customer_id');
            $table->integer('user_id');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('total_tax', 10, 2);
            $table->decimal('total_dicount', 10, 2);
            $table->decimal('final_amount', 10, 2);
            $table->integer('poin_earned');
            $table->integer('poin_redeemed');
            $table->enum('payment_method', ['cash', 'credit', 'debit', 'e-wallet']);
            $table->timestamp('transaction_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};