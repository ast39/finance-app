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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id('deposit_id');
            $table->integer('owner_id')
                ->comment('Хозяин вклада');
            $table->string('title', 64)
                ->comment('Название вклада');
            $table->string('depositor', 64)
                ->comment('Банк эмитент');
            $table->unsignedFloat('amount', 11, 2)
                ->comment('Сумма вклада');
            $table->unsignedFloat('percent', 9, 4)
                ->comment('Процент по вкладу');
            $table->unsignedInteger('period')
                ->comment('Срок вклада');
            $table->unsignedFloat('refill', 11, 2)
                ->comment('Сумма ежемесячных пополнений')
                ->default(0);
            $table->unsignedInteger('capitalization')
                ->comment('Частота капитализации процентов');
            $table->boolean('withdrawal')
                ->comment('Снимать проценты');
            $table->unsignedInteger('start_date')
                ->comment('Дата открытия вклада');
            $table->unsignedTinyInteger('status')
                ->default(1);

            $table->timestamps();
        });

        Schema::table('deposit_payments', function(Blueprint $table) {
            $table->foreign('deposit_id', 'deposit_payment_key')
                ->references('deposit_id')
                ->on('deposits')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
