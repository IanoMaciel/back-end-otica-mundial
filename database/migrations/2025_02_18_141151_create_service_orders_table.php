<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sale_id')->nullable();
            $table->foreign('sale_id')->references('id')->on('sales')->nullOnDelete();

            $table->string('number_ata')->nullable();
            $table->date('delivery')->nullable();
            $table->string('spherical_left')->nullable();
            $table->string('spherical_right')->nullable();
            $table->string('cylindrical_left')->nullable();
            $table->string('cylindrical_right')->nullable();
            $table->string('axis_left')->nullable();
            $table->string('axis_right')->nullable();
            $table->string('dnp_left')->nullable();
            $table->string('dnp_right')->nullable();
            $table->string('height_left')->nullable();
            $table->string('height_right')->nullable();
            $table->string('addition_left')->nullable();
            $table->string('addition_right')->nullable();
            $table->string('bridge')->nullable();
            $table->string('major_horizontal')->nullable();
            $table->string('minor_horizontal')->nullable();
            $table->string('dnp_v_left')->nullable();
            $table->string('dnp_v_right')->nullable();
            $table->string('alt_left')->nullable();
            $table->string('alt_right')->nullable();

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
        Schema::dropIfExists('service_orders');
    }
}
