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
        Schema::table('wallets', function(Blueprint $table) {
            $table->foreign('owner_id', 'wallet_owner_key')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('wallets', function(Blueprint $table) {
            $table->foreign('currency_id', 'wallet_currency_key')
                ->references('currency_id')
                ->on('wallet_currencies')
                ->onDelete('cascade');
        });

        Schema::table('wallet_payments', function(Blueprint $table) {
            $table->foreign('wallet_id', 'wallet_payment_key')
                ->references('wallet_id')
                ->on('wallets')
                ->onDelete('cascade');
        });


        Schema::table('credits', function(Blueprint $table) {
            $table->foreign('owner_id', 'credit_owner_key')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('credit_calculates', function(Blueprint $table) {
            $table->foreign('owner_id', 'credit_calc_owner_key')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('credit_payments', function(Blueprint $table) {
            $table->foreign('credit_id', 'credit_payment_key')
                ->references('credit_id')
                ->on('credits')
                ->onDelete('cascade');
        });


        Schema::table('deposits', function(Blueprint $table) {
            $table->foreign('owner_id', 'deposit_owner_key')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('deposit_calculates', function(Blueprint $table) {
            $table->foreign('owner_id', 'deposit_calc_owner_key')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('deposit_payments', function(Blueprint $table) {
            $table->foreign('deposit_id', 'deposit_payment_key')
                ->references('deposit_id')
                ->on('deposits')
                ->onDelete('cascade');
        });


        Schema::table('spends', function(Blueprint $table) {
            $table->foreign('owner_id', 'spend_owner_key')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('spends', function(Blueprint $table) {
            $table->foreign('wallet_id', 'spend_wallet_key')
                ->references('wallet_id')
                ->on('wallets')
                ->onDelete('cascade');
        });

        Schema::table('spends', function(Blueprint $table) {
            $table->foreign('category_id', 'category_key')
                ->references('category_id')
                ->on('spending_categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
