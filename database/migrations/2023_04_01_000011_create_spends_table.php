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
        Schema::create('spends', function (Blueprint $table) {
            $table->id('spend_id');
            $table->unsignedBigInteger('owner_id')
                ->comment('Хозяин транзакции');
            $table->unsignedBigInteger('category_id')
                ->comment('Категория транзакции');
            $table->float('amount',11, 2)
                ->comment('Сумма транзакции');
            $table->mediumText('note')
                ->nullable()
                ->comment('Примечание к транзакции');
            $table->unsignedTinyInteger('status')
                ->default(1);

            $table->timestamps();

            $table->comment('Траты пользователей');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spends');
    }
};
