<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRemoveColumnPercentageTable extends Migration {
    public function up(): void {
        Schema::table('sensitivities', function (Blueprint $table) {
            $table->dropColumn('percentage');
        });
    }

    public function down(): void {
        Schema::table('sensitivities', function (Blueprint $table) {
            $table->decimal('percentage', 10, 2)->nullable();
        });
    }
}
