<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('price')->nullable();
            $table->string('address')->nullable();
            $table->integer('agent_id')->default(0);
            $table->enum('agent_type', ['agent', 'admin']);
            $table->enum('listing_type', ['sale', 'rent']);
            $table->integer('property_type_id');
            $table->integer('land_size')->nullable();
            $table->integer('built_up')->nullable();
            $table->string('description')->nullable();
            $table->integer('area')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('beds')->nullable();
            $table->integer('garages')->nullable();
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
        Schema::dropIfExists('properties');
    }
}
