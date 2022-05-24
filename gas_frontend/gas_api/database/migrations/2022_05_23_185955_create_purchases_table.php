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
            $table->increments('id');
            $table->timestamp('date');
            $table->string('receipt_number');
            $table->string('receipt_attachment_path');
            $table->string('company_name');
            $table->string('company_phone_name');
            $table->string('driver_name');
            $table->string('gas_quantity');
            $table->integer('amount');
            $table->integer('unit_price');
            $table->enum('status', ['pending', 'delivered','cancelled'])->default('pending');
            $table->integer('user_id')->unsigned();
            $table->integer('payment_status_id')->unsigned();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('purchases');
    }
}
