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
        Schema::create('wallet_payments', function (Blueprint $table) {
            $table->id('payment_id');
            $table->unsignedBigInteger('wallet_id')
                ->comment('Транзакция к кошельку');
            $table->unsignedFloat('amount', 11, 2)
                ->comment('Сумма транзакции');
            $table->tinyText('note')
                ->nullable()
                ->comment('Примечание к транзакции');
            $table->unsignedTinyInteger('status')
                ->default(1);

            $table->timestamps();

            $table->comment('Транзакции по кошелькам');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_payments');
    }
};
