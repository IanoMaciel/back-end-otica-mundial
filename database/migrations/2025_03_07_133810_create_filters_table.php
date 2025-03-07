<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiltersTable extends Migration {
    public function up(): void {
        Schema::create('filters', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('promotion_id')->nullable();
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('cascade');

            $table->string('type')->nullable();
            $table->string('name')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('filters');
    }
}
