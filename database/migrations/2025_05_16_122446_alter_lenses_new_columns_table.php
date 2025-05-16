<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLensesNewColumnsTable extends Migration {
    public function up(): void {
        Schema::table('lenses', function (Blueprint $table) {
            $table->dropColumn(['surfacing', 'index', 'height', 'diameter']);

            $table->unsignedBigInteger('surfacing_id')->nullable();
            $table->foreign('surfacing_id')->references('id')->on('surfacings')->nullOnDelete();

            $table->unsignedBigInteger('index_id')->nullable();
            $table->foreign('index_id')->references('id')->on('indices')->nullOnDelete();

            $table->unsignedBigInteger('height_id')->nullable();
            $table->foreign('height_id')->references('id')->on('heights')->nullOnDelete();

            $table->unsignedBigInteger('diameter_id')->nullable();
            $table->foreign('diameter_id')->references('id')->on('diameters')->nullOnDelete();

            $table->unsignedBigInteger('laboratory_lens_id')->nullable();
            $table->foreign('laboratory_lens_id')->references('id')->on('laboratories')->nullOnDelete();

            $table->decimal('profit', 10, 2)->nullable();
        });
    }

    public function down(): void {
        Schema::table('lenses', function (Blueprint $table) {
            $table->dropForeign(['surfacing_id']);
            $table->dropForeign(['index_id']);
            $table->dropForeign(['height_id']);
            $table->dropForeign(['diameter_id']);
            $table->dropForeign(['laboratory_lens_id']);

            $table->dropColumn(['surfacing_id', 'index_id', 'height_id', 'diameter_id', 'laboratory_lens_id', 'profit']);

            $table->tinyInteger('surfacing')->default(0)->nullable();
            $table->decimal('index', 10, 2)->nullable();
            $table->string('height', 10)->default('0')->nullable();
            $table->decimal('diameter', 10, 2)->default(0.00)->nullable();
        });
    }
}
