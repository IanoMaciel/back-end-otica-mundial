<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCustomersAddColumnFlagTable extends Migration {
    public function up(): void {
        Schema::table('customers', function (Blueprint $table) {
            $table->enum('flag', ['red', 'orange'])->nullable()->after('number_agreement');
        });
    }

    public function down(): void {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('flag');
        });
    }
}
