<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration {
    public function up(): void {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->enum('status', ['Ativa', 'Inativa', 'Agendada'])->default('Agendada')->nullable();
            $table->enum('auth', ['Administrador', 'Gerente', 'Loja'])->default('Loja')->nullable();
            $table->decimal('store_credit_discount', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('promotions');
    }
}
