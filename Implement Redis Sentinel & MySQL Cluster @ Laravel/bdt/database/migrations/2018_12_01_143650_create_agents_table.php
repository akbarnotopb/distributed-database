<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('plain_text_password', 16)->nullable();
            $table->integer('approved')->default(0);
            $table->string('address', 255)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('nik', 20)->nullable();
            $table->string('bank_name', 32)->nullable();
            $table->string('bank_customer', 64)->nullable();
            $table->string('bank_account', 64)->nullable();
            $table->string('registration_number', 50)->nullable();
            $table->string('branch_code', 50)->nullable();
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
        Schema::dropIfExists('agents');
    }
}
