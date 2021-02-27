<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->onDelete('NO ACTION');
            $table->double('amount', 18, 2)->default(0)->comment('Can be partial');
            $table->foreignId('payment_source_id')->nullable()->constrained()->onDelete('SET NULL');
            $table->string('payment_source')->nullable();
            $table->string('receipt_no')->nullable();
            $table->date('payment_date')->useCurrent();
            $table->string('transaction_reference')->nullable();
            $table->string('private_notes')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
