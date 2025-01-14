<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCombinedPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('combined_payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sale_id')->nullable();
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');

            $table->unsignedBigInteger('form_payment_id')->nullable();
            $table->foreign('form_payment_id')->references('id')->on('form_payments')->onDelete('cascade');

            $table->unsignedBigInteger('card_id')->nullable();
            $table->foreign('card_id')->references('id')->on('cards')->onDelete('cascade');

            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('combined_payments');
    }
}
