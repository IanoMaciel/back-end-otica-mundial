<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallmentsTable extends Migration {
    public function up(): void {
        Schema::create('installments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('payment_credit_id')->nullable();
            $table->foreign('payment_credit_id')->references('id')->on('payment_credits')->onDelete('cascade');

            $table->unsignedBigInteger('form_payment_id')->nullable();
            $table->foreign('form_payment_id')->references('id')->on('form_payments')->onDelete('cascade');

            $table->unsignedBigInteger('card_id')->nullable();
            $table->foreign('card_id')->references('id')->on('cards')->onDelete('cascade');

            $table->date('due_date')->nullable();

            $table->enum('status', ['Pendente', 'Pago', 'Atrasado'])->default('Pendente');

            $table->decimal('amount', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('installments');
    }
}
