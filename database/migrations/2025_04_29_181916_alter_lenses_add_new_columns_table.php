<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLensesAddNewColumnsTable extends Migration {
    public function up(): void {
        Schema::table('lenses', function (Blueprint $table) {
            $table->boolean('surfacing')->default(false)->nullable()->after('treatment_id');
            $table->decimal('cost', 10, 2)->nullable()->after('price');
            $table->decimal('diameter', 10, 2)->default(0)->nullable()->after('addition_end');
            $table->decimal('height', 10, 2)->default(0)->nullable()->after('diameter');
        });
    }

    public function down(): void {
        Schema::table('lenses', function (Blueprint $table) {
            $table->dropColumn(['surfacing', 'diameter', 'height']);
        });
    }
}
