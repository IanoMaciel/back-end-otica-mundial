<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiametersTable extends Migration {
    public function up(): void {
        Schema::create('diameters', function (Blueprint $table) {
            $table->id();
            $table->decimal('diameter', 10, 2);
        });
    }

    public function down(): void {
        Schema::dropIfExists('diameters');
    }
}
