<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSaleItemsAddDiscountIdTable extends Migration {
    public function up(): void {
        Schema::table('sale_items', function (Blueprint $table) {
            $table->unsignedBigInteger('discount_id')
                ->after('discount')->nullable();

            $table->foreign('discount_id')
                ->references('id')
                ->on('discounts')
                ->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::table('sale_items', function (Blueprint $table) {
            $table->dropForeign('discount_id');
            $table->dropColumn('discount_id');
        });
    }
}
