<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPromotionsAddRetroativoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotions', function (Blueprint $table) {
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE promotions MODIFY COLUMN status ENUM('Ativa', 'Inativa', 'Agendada', 'Retroativa') DEFAULT 'Agendada'");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotions', function (Blueprint $table) {
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE promotions MODIFY COLUMN status ENUM('Ativa', 'Inativa', 'Agendada', 'Retroativa') DEFAULT 'Agendada'");
        });
    }
}
