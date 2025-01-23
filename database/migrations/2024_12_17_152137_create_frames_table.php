<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFramesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('frames', function (Blueprint $table) {
            $table->id();

            $table->string('barcode')->unique()->nullable();    // código de barra

            $table->string('code')->nullable(); // código da armação
            $table->integer('size')->nullable();            // tamanho da armação
            $table->integer('haste')->nullable();           // haste da armação
            $table->integer('bridge')->nullable();          // ponte da armação
            $table->string('color', 30)->nullable(); // cor da armação

            $table->integer('amount')->nullable();                               // quantidade estoque
            $table->decimal('purchase_value', 10, 2)->nullable();   // valor da compra
            $table->decimal('profit', 10, 2)->nullable();           // lucro
            $table->decimal('price', 10, 2)->nullable();            // valor de venda
            $table->text('description', 255)->nullable();                        // descrição

            $table->unsignedBigInteger('supplier_id')->nullable();      // fornecedor_id
            $table->unsignedBigInteger('brand_id')->nullable();         // grife_id
            $table->unsignedBigInteger('material_id')->nullable();      // material_id

            $table->foreign('supplier_id')->references('id')->on('suppliers')->nullOnDelete();
            $table->foreign('brand_id')->references('id')->on('brands')->nullOnDelete();
            $table->foreign('material_id')->references('id')->on('materials')->nullOnDelete();

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
        Schema::dropIfExists('frames');
    }
}
