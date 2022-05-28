<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->text('phone_number')->nullable();
            $table->string('password');
            $table->string('designation');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamp('last_login_at')->nullable();
            $table->longText('permissions')->nullable();
            $table->integer('user_type_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->timestamps();
            $table->foreign('user_type_id')->references('id')->on('user_types')->onDelete('cascade');
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
        Schema::dropIfExists('users');
    }
}
