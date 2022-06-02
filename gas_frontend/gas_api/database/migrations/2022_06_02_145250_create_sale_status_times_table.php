<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleStatusTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_status_times', function (Blueprint $table) {
            $table->id();
            $table->text('status');
            $table->date('status_time');
            $table->integer('sale_id')->unsigned();
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');

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
        Schema::dropIfExists('sale_status_times');
    }
}
