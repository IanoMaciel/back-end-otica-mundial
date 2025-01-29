<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaboratoriesTable extends Migration {
    public function up(): void {
        Schema::create('laboratories', function (Blueprint $table) {
            $table->id();
            $table->string('laboratory', 30)->nullable();
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('laboratories');
    }
}
