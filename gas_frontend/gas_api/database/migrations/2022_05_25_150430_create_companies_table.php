<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('owner_name');
            $table->string('company_email')->unique();
            $table->string('company_name')->unique();
            $table->text('company_phone_number')->unique();
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('gas_plant_type')->nullable();
            $table->string('password');
            $table->longText('permissions');
            $table->string('company_profile_picture')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
