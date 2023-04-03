<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('credit_payments', function (Blueprint $table) {
            $table->id('payment_id');
            $table->unsignedBigInteger('credit_id')
                ->comment('Погашаемый кредит');
            $table->float('amount', 11, 2)
                ->comment('Сумма платежа');
            $table->tinyText('note')
                ->nullable()
                ->comment('Примечание к пополнению');
            $table->unsignedTinyInteger('status')
                ->default(1);

            $table->timestamps();

            $table->comment('Платежи по кредитам');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_payments');
    }
};
