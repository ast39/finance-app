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
        Schema::create('credits', function (Blueprint $table) {
            $table->id('credit_id');
            $table->unsignedInteger('owner_id')
                ->comment('Хозяин кредита');
            $table->string('title', 64)
                ->comment('Название кредита');
            $table->string('creditor', 64)
                ->comment('Банк эмитент');
            $table->unsignedFloat('amount',11, 2)
                ->comment('Сумма кредита');
            $table->unsignedFloat('percent', 9, 4)
                ->comment('Процент по кредиту');
            $table->unsignedInteger('period')
                ->comment('Срок кредита');
            $table->unsignedFloat('payment', 11, 2)
                ->comment('Платеж по  кредиту');
            $table->unsignedInteger('start_date')
                ->comment('Дата открытия кредита');
            $table->unsignedInteger('payment_date')
                ->comment('День платежа по кредиту');
            $table->unsignedTinyInteger('status')
                ->default(1);

            $table->timestamps();

            $table->comment('Кредиты пользователей');
        });

        Schema::table('credit_payments', function(Blueprint $table) {
            $table->foreign('credit_id', 'credit_payment_key')
                ->references('credit_id')
                ->on('credits')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credits');
    }
};
