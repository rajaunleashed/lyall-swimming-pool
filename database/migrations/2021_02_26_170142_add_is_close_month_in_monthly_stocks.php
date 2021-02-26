<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsCloseMonthInMonthlyStocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monthly_stocks', function (Blueprint $table) {
            $table->boolean('is_month_closed')->after('date')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monthly_stocks', function (Blueprint $table) {
            $table->dropColumn('is_month_closed');
        });
    }
}
