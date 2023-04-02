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
        Schema::create('spending_categories', function (Blueprint $table) {
            $table->id('category_id');
            $table->string('title')
                ->comment('Название категории');
            $table->unsignedInteger('parent_id')
                ->nullable()
                ->default(null)
                ->comment('Родительская категория');

            $table->timestamps();

            $table->comment('Категории трат');
        });

        Schema::table('spends', function(Blueprint $table) {
            $table->foreign('category_id', 'category_key')
                ->references('category_id')
                ->on('spending_categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spending_categories');
    }
};
