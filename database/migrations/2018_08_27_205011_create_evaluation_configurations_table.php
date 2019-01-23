<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_configurations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('action_test_id')->unsigned();
            $table->foreign('action_test_id')
                  ->references('id')
                  ->on('action_tests')
                  ->onDelete('cascade');
            $table->integer('action_configuration_id')->unsigned();
            $table->foreign('action_configuration_id')
                  ->references('id')
                  ->on('action_configurations')
                  ->onDelete('cascade');
            $table->integer('value');
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
        Schema::dropIfExists('evaluation_configurations');
    }
}
