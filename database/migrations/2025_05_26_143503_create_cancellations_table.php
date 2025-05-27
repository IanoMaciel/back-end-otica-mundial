<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCancellationsTable extends Migration {
    public function up(): void {
        Schema::create('cancellations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sale_id')->nullable();
            $table->foreign('sale_id')->references('id')->on('sales')->nullOnDelete();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();

            $table->string('reason',)->nullable();
            $table->text('observation', 255)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('cancellations');
    }
}
