<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gas_quantity');
            $table->float('amount');
            $table->string('discount_code')->nullable();
            $table->integer('transaction_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('payment_mode_id')->unsigned();
            $table->integer('payment_status_id')->unsigned();
            $table->timestamps();
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('payment_mode_id')->references('id')->on('payment_modes');
            $table->foreign('payment_status_id')->references('id')->on('payment_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
