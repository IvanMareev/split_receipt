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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained("users"); // связь с пользователем
            $table->decimal('total_sum', 8, 2); // сумма с двумя знаками после запятой
            $table->string('status')->default('pending'); // статус счета
            $table->date('payment_date')->nullable(); // дата оплаты
            $table->text('description')->nullable(); // описание
            $table->timestamps(); // created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills_new');
    }
};
