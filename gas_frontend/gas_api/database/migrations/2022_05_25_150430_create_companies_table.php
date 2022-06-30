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
            $table->string('company_email');
            $table->string('company_name');
            $table->text('company_phone_number');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('password');
            $table->boolean('is_super_admin');
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
