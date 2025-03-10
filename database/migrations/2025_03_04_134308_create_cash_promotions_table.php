<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashPromotionsTable extends Migration {
    public function up(): void {
        Schema::create('cash_promotions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('promotion_id')->nullable();
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('cascade');

            $table->unsignedBigInteger('form_payment_id')->nullable();
            $table->foreign('form_payment_id')->references('id')->on('form_payments')->onDelete('cascade');

            $table->decimal('discount', 10, 2)->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('cash_promotions');
    }
}
