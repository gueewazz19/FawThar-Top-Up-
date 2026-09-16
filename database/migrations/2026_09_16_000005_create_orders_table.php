<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('game_id')->constrained('games')->restrictOnDelete();
            $table->string('order_number', 32)->unique()->index();
            $table->string('player_id', 100);
            $table->string('server_id', 100)->nullable();
            $table->decimal('subtotal', 12, 2)->unsigned();
            $table->decimal('discount', 12, 2)->unsigned()->default(0);
            $table->decimal('payment_fee', 12, 2)->unsigned()->default(0);
            $table->decimal('total', 12, 2)->unsigned();
            $table->enum('status', [
                'PENDING_PAYMENT',
                'PAID',
                'PROCESSING',
                'SUCCESS',
                'FAILED',
                'CANCELLED',
                'REFUNDED',
                'TOPUP_FAILED'
            ])->default('PENDING_PAYMENT')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
