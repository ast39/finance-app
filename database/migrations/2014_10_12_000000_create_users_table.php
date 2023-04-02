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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('credits', function(Blueprint $table) {
            $table->foreign('owner_id', 'credit_owner_key')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('deposits', function(Blueprint $table) {
            $table->foreign('owner_id', 'deposit_owner_key')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('wallets', function(Blueprint $table) {
            $table->foreign('owner_id', 'wallet_owner_key')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('spends', function(Blueprint $table) {
            $table->foreign('owner_id', 'spend_owner_key')
                ->references('user_id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
