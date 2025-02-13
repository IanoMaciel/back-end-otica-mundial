<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration {
    public function up(): void {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('discount_type', 30)->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('discounts');
    }
}
