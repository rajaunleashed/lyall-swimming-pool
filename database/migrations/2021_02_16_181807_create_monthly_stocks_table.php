<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('SET NULL');
            $table->string('product_name')->nullable();
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('SET NULL');
            $table->string('supplier_name')->nullable();
            $table->bigInteger('opening_stock');
            $table->double('stock_in', 18, 2);
            $table->bigInteger('quantity')->default(0);
            $table->bigInteger('stock_out')->default(0);
            $table->bigInteger('bonus')->nullable()->default(0);
            $table->bigInteger('expired')->nullable()->default(0);
            $table->date('date')->useCurrent();
            $table->boolean('is_month_closed')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monthly_stocks');
    }
}
