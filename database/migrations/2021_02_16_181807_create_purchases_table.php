<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('SET NULL');
            $table->string('product_name')->nullable();
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('SET NULL');
            $table->string('supplier_name')->nullable();
            $table->double('price');
            $table->double('stock_in');
            $table->bigInteger('stock_out')->default(0);
            $table->date('date')->useCurrent();
            $table->boolean('paid_status')->comment('0=unpaid,1=paid')->default(1);
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
        Schema::dropIfExists('purchases');
    }
}
