<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeightsTable extends Migration {
    public function up(): void {
        Schema::create('heights', function (Blueprint $table) {
            $table->id();
            $table->string('height')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('heights');
    }
}
