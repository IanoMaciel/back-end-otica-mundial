<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultifocalLensesTable extends Migration {
    public function up(): void {
        Schema::create('multifocal_lenses', function (Blueprint $table) {
            $table->id();

            $table->string('barcode')->unique()->nullable();

            $table->unsignedBigInteger('lens_id')->nullable();
            $table->foreign('lens_id')->references('id')->on('lenses')->onDelete('cascade');

            $table->decimal('spherical', 10, 2)->nullable();
            $table->decimal('addition', 10, 2)->nullable();
            $table->integer('left')->default(0);
            $table->integer('right')->default(0);
            $table->integer('cropped_lens_left')->default(0);
            $table->integer('cropped_lens_right')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('multifocal_lenses');
    }
}
