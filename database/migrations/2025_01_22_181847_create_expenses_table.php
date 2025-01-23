<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('category_expense_id')->nullable();
            $table->foreign('category_expense_id')->references('id')->on('category_expenses')->nullOnDelete();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();

            $table->string('title', 100)->nullable();

            $table->decimal('total_amount', 10, 2)->nullable();
            $table->date('date_proof')->nullable();

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
        Schema::dropIfExists('expenses');
    }
}
