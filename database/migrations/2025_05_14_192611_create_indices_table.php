<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicesTable extends Migration {
    public function up(): void {
        Schema::create('indices', function (Blueprint $table) {
            $table->id();
            $table->decimal('index', 10, 2)->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('indices');
    }
}
