<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditPromotionsTable extends Migration {
    public function up(): void {
        Schema::create('credit_promotions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('promotion_id')->nullable();
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('cascade');

            $table->integer('installment')->nullable();
            $table->decimal('discount', 10, 2)->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('credit_promotions');
    }
}
