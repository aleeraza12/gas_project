<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gas_quantity');
            $table->string('unit_price');
            $table->float('amount');
            $table->string('order_id');
            $table->enum('status', ['pending', 'delivered','cancelled'])->default('pending');
            $table->integer('customer_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('payment_mode_id')->unsigned();
            $table->integer('payment_status_id')->unsigned();
            $table->timestamps();
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
        Schema::dropIfExists('orders');
    }
}
