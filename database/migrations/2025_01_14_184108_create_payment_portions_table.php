<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentPortionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_portions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('combined_payment_id')->nullable();
            $table->foreign('combined_payment_id')->references('id')->on('combined_payments')->onDelete('cascade');

            $table->unsignedBigInteger('form_payment_id')->nullable();
            $table->foreign('form_payment_id')->references('id')->on('form_payments')->onDelete('cascade');

            $table->unsignedBigInteger('card_id')->nullable();
            $table->foreign('card_id')->references('id')->on('cards')->onDelete('cascade');

            $table->decimal('amount', 10, 2)->nullable();

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
        Schema::dropIfExists('payment_portions');
    }
}
