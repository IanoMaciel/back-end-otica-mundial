<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLensesLaboraryLensTable extends Migration {
    public function up(): void {
        Schema::table('lenses', function (Blueprint $table) {
            $table->dropForeign(['laboratory_lens_id']);
            $table->dropColumn('laboratory_lens_id');
            $table->string('laboratory_lens')->nullable();
        });
    }

    public function down(): void {
        Schema::table('lenses', function (Blueprint $table) {
            $table->dropColumn('laboratory_lens');

            $table->unsignedBigInteger('laboratory_lens_id')->nullable();
            $table->foreign('laboratory_lens_id')->references('id')->on('laboratory_lenses');
        });
    }

}
