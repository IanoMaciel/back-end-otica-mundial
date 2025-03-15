<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSaleItemsTable extends Migration {
    public function up(): void{
        Schema::table('sale_items', function (Blueprint $table) {
            $table->unsignedBigInteger('promotion_id')->nullable();
            $table->foreign('promotion_id')->references('id')->on('promotions')->nullOnDelete();

            $table->morphs('paymentable');
            $table->decimal('store_credit', 10, 2)->nullable();
            $table->decimal('discount_value', 10, 2)->nullable();
            $table->decimal('discount_percentage', 10, 2)->nullable();
            $table->decimal('final_price', 10, 2)->nullable();
        });
    }

    public function down(): void {
        Schema::table('sale_items', function (Blueprint $table) {
            $table->dropForeign(['promotion_id']);

            $table->dropColumn([
                'promotion_id',
                'store_credit',
                'discount_value',
                'discount_percentage',
                'final_price'
            ]);

            $table->dropMorphs('paymentable');
        });
    }

}
