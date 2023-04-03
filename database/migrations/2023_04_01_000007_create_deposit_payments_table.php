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
        Schema::create('deposit_payments', function (Blueprint $table) {
            $table->id('payment_id');
            $table->unsignedBigInteger('deposit_id')
                ->comment('Пополняемый вклад');
            $table->float('amount', 11, 2)
                ->comment('Сумма пополнения');
            $table->tinyText('note')
                ->nullable()
                ->comment('Примечание к пополнению');
            $table->unsignedTinyInteger('status')
                ->default(1);

            $table->timestamps();

            $table->comment('Транзакции по вкладам');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposit_payments');
    }
};
