<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLensesTable extends Migration {
    public function up(): void {
        Schema::create('lenses', function (Blueprint $table) {
            $table->id();

            $table->string('barcode')->unique()->nullable();

            $table->unsignedBigInteger('type_lens_id')->nullable();
            $table->foreign('type_lens_id')->references('id')->on('type_lenses')->nullOnDelete();

            $table->decimal('index', 10, 2)->nullable();

            $table->unsignedBigInteger('treatment_id')->nullable();
            $table->foreign('treatment_id')->references('id')->on('treatments')->nullOnDelete();

            $table->boolean('filter')->nullable();

            $table->unsignedBigInteger('sensitivity_id')->nullable();
            $table->foreign('sensitivity_id')->references('id')->on('sensitivities')->nullOnDelete();

            $table->string('name_lens')->nullable();

            $table->decimal('spherical', 10, 2)->nullable();
            $table->decimal('cylindrical', 10, 2)->nullable();
            $table->decimal('addition', 10, 2)->nullable();

            $table->unsignedBigInteger('laboratory_id')->nullable();
            $table->foreign('laboratory_id')->references('id')->on('laboratories')->nullOnDelete();

            $table->decimal('minimum_value', 10, 2)->nullable();

            $table->integer('delivery')->nullable();

            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('price', 10, 2)->nullable();

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
        Schema::dropIfExists('lenses');
    }
}
