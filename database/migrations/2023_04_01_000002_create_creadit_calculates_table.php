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
        Schema::create('credit_calculates', function (Blueprint $table) {
            $table->id('credit_id');
            $table->string('title', 64)
                ->comment('Название кредита');
            $table->unsignedInteger('payment_type')
                ->comment('Тип платежа - аннуитетный или дифференцированный')
                ->default(1);
            $table->string('subject', 8)
                ->comment('Предмет кредитования')
                ->nullable();
            $table->unsignedFloat('amount',11, 2)
                ->nullable()
                ->comment('Сумма кредита');
            $table->unsignedFloat('percent', 9, 4)
                ->nullable()
                ->comment('Процент по кредиту');
            $table->unsignedInteger('period')
                ->nullable()
                ->comment('Срок кредита');
            $table->unsignedFloat('payment', 11, 2)
                ->nullable()
                ->comment('Платеж по  кредиту');

            $table->timestamps();

            $table->comment('Предварительные расчеты кредитов');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_calculates');
    }
};
