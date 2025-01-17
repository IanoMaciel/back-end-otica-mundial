<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterInstallmentsAddInstallmentTable extends Migration {
    public function up(): void {
        Schema::table('installments', function (Blueprint $table) {
            $table->integer('installment')->nullable()->after('card_id');
        });
    }

    public function down(): void {
        Schema::table('installments', function (Blueprint $table) {
            $table->dropColumn('installment');
        });
    }
}
