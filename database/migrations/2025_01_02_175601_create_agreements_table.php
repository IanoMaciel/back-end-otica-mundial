<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgreementsTable extends Migration {

    public function up(): void {
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            $table->string('agreement', 30);
        });
    }

    public function down(): void {
        Schema::dropIfExists('agreements');
    }
}
