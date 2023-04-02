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
        Schema::create('deposit_calculates', function (Blueprint $table) {
            $table->id('deposit_id');
            $table->string('title', 64)
                ->comment('Название вклада');
            $table->unsignedInteger('start_date');
            $table->unsignedFloat('amount', 11, 2)
                ->nullable()
                ->comment('Сумма вклада');
            $table->unsignedFloat('percent', 9, 4)
                ->nullable()
                ->comment('Процент по вкладу');
            $table->unsignedInteger('period')
                ->nullable()
                ->comment('Срок вклада');
            $table->unsignedFloat('refill', 11, 2)
                ->default(0)
                ->comment('Сумма ежемесячного пополнения');
            $table->unsignedInteger('capitalization')
                ->comment('Частота капитализации процентов');
            $table->boolean('withdrawal')
                ->comment('Снимать проценты');
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposit_calculates');
    }
};
