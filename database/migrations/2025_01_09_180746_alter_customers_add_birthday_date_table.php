<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCustomersAddBirthdayDateTable extends Migration {
    public function up(): void {
        Schema::table('customers', function (Blueprint $table) {
            $table->date('birth_date')->after('full_name')->nullable();
        });
    }

    public function down(): void{
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('birth_date');
        });
    }
}
