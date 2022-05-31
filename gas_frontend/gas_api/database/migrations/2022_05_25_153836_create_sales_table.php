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
            $table->float('total_amount');
            $table->float('price');
            $table->string('discount_code')->nullable();
            //$table->integer('customer_id')->unsigned();
            $table->string('customer_name');
            $table->string('customer_type');
            $table->string('customer_phone_number');
            //$table->integer('user_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->enum('payment_mode', ['cash', 'prepaid'])->default('cash');
            $table->enum('status', ['paid', 'unpaid'])->default('unpaid');
            $table->timestamps();
            //$table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('sales');
    }
}
