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
            $table->string('receipt_attachment_path')->nullable();
            $table->boolean('paid')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->boolean('unpaid')->nullable();
            $table->dateTime('unpaid_at')->nullable();
            $table->boolean('delivered')->nullable();
            $table->dateTime('delivered_at')->nullable();
            $table->string('company_name');
            $table->string('company_phone_number');
            $table->string('driver_name');
            $table->string('gas_quantity');
            $table->double('amount');
            $table->double('unit_price');
            $table->integer('company_id')->unsigned();
            $table->enum('status', ['pending', 'delivered', 'cancelled'])->default('pending');
            $table->string('recepient_name')->nullable();
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
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
