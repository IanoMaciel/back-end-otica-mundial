<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurfacingsTable extends Migration {
    public function up(): void {
        Schema::create('surfacings', function (Blueprint $table) {
            $table->id();
            $table->string('surfacing')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('surfacings');
    }
}
