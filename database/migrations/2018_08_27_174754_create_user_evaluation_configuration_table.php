<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserEvaluationConfigurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_evaluation_configuration', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
//            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('evaluation_configuration_id')->unsigned();
//            $table->foreign('evaluation_configuration_id')->references('id')->on('evaluation_configurations');
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
        Schema::dropIfExists('user_evaluation_configuration');
    }
}
