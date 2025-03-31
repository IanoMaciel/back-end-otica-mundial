<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSalesAddDateTable extends Migration {

    public function up(): void {
        Schema::table('sales', function (Blueprint $table) {
            $table->timestamp('date_sale')->after('total_amount')->nullable();
        });
    }

    public function down(): void {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('date_sale');
        });
    }
}
