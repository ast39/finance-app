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
        Schema::create('credit_checks', function (Blueprint $table) {
            $table->id('calc_id');
            $table->unsignedBigInteger('owner_id')
                ->nullable()
                ->default(null)
                ->comment('Хозяин расчета');
            $table->string('title', 64)
                ->comment('Название кредитного предложения');
            $table->string('currency', 4)
                ->comment('Валюта кредита')
                ->default('RUB');
            $table->unsignedFloat('amount',11, 2)
                ->comment('Сумма кредита');
            $table->unsignedFloat('percent', 9, 4)
                ->comment('Процент по кредиту');
            $table->unsignedInteger('period')
                ->comment('Срок кредита');
            $table->unsignedFloat('payment', 11, 2)
                ->comment('Платеж по  кредиту');

            $table->timestamps();

            $table->comment('Проверки условий кредитных предложений');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_checks');
    }
};
