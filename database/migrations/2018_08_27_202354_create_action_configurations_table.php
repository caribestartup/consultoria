<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_configurations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('action_id')->unsigned();
//            $table->foreign('action_id')->references('id')->on('actions');
            $table->integer('action_plan_configuration_id')->unsigned();
//            $table->foreign('action_plan_configuration_id')->references('id')->on('action_plan_configurations');
            $table->date('start_date')->nullable();
            $table->date('ending_date')->nullable();
            $table->date('started_date')->nullable();
            $table->date('estimated_fulfillment_date')->nullable();
            $table->date('real_fulfillment_date')->nullable();
            $table->integer('current_objectives')->nullable();
            $table->boolean('collaboration')->default(false);
            $table->boolean('done_before')->default(false);
            $table->boolean('know_what_to_do')->default(false);
            $table->integer('knowledge_level')->nullable();
            $table->boolean('know_how_to_improve')->default(false);
            $table->text('improve_knowledge')->nullable();
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
        Schema::dropIfExists('action_configurations');
    }
}
