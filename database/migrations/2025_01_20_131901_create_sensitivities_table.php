<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensitivitiesTable extends Migration {
    public function up() {
        Schema::create('sensitivities', function (Blueprint $table) {
            $table->id();
            $table->string('sensitivity')->nullable();
            $table->decimal('percentage', 10, 2)->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('sensitivities');
    }
}
