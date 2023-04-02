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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id('wallet_id');
            $table->unsignedTinyInteger('currency_id')
                ->default('1')
                ->comment('Валюта кошелька');
            $table->unsignedInteger('owner_id')
                ->comment('Владелец кошелька');
            $table->string('title', 64)
                ->comment('Название кошелька');
            $table->mediumText('note')
                ->nullable()
                ->comment('Примечание к кошельку');
            $table->float('amount',11, 2)
                ->default(0)
                ->comment('Баланс кошелька');
            $table->unsignedTinyInteger('status')
                ->default(1);

            $table->timestamps();

            $table->comment('Кошельки пользователей');
        });

        Schema::table('wallet_payments', function(Blueprint $table) {
            $table->foreign('wallet_id', 'wallet_payment_key')
                ->references('wallet_id')
                ->on('wallets')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
