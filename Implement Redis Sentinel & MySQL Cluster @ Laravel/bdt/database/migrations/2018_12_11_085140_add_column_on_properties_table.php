<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOnPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->integer('maid_bedrooms')->nullable()->after('approved');
            $table->integer('maid_bathrooms')->nullable()->after('maid_bedrooms');
            $table->string('certificate')->nullable()->after('maid_bathrooms');
            $table->integer('year_built')->nullable()->after('certificate');
            $table->integer('electrical_power')->nullable()->after('year_built');
            $table->integer('number_of_floors')->nullable()->after('electrical_power');
            $table->string('amount_of_down_payment')->nullable()->after('number_of_floors');
            $table->integer('estimated_installments')->nullable()->after('amount_of_down_payment');
            $table->string('complete_address')->nullable()->after('estimated_installments');
            $table->string('floor_number')->nullable()->after('complete_address');
            $table->string('parking_amount')->nullable()->after('floor_number');
            $table->string('owner_name')->nullable()->after('parking_amount');
            $table->string('owner_phone')->nullable()->after('owner_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['maid_bedrooms', 'maid_bathrooms', 'certificate', 'year_built', 'electrical_power', 'number_of_floors', 'amount_of_down_payment', 'estimated_installments', 'complete_address', 'floor_number', 'parking_amount', 'owner_name', 'owner_phone']);
        });
    }
}
