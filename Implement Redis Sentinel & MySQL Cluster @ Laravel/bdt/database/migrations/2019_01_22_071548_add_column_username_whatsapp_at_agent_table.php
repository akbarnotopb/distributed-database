<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnUsernameWhatsappAtAgentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('agents',function(Blueprint $table){
            $table->string('username')->nullable()->unique();
            $table->string('whatsapp',20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('agents',function(Blueprint $table){
            $table->dropColumn(['username','whatsapp']);
        });
    }
}
