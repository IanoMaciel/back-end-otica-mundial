<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSingleVisionsTable extends Migration
{

    public function up(): void
    {
        Schema::create('single_visions', function (Blueprint $table) {
            $table->id();

            $table->string('barcode')->unique()->nullable();

            $table->unsignedBigInteger('lens_id')->nullable();
            $table->foreign('lens_id')->references('id')->on('lenses')->onDelete('cascade');

            $table->decimal('spherical', 10, 2)->nullable();
            $table->decimal('cylindrical', 10, 2)->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('cropped_lens')->default(0);

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
        Schema::dropIfExists('single_visions');
    }
}
