<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionPlanTopicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_plan_topic', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('action_plan_id')->unsigned();
//            $table->foreign('action_plan_id')->references('id')->on('action_plans');
            $table->integer('topic_id')->unsigned();
//            $table->foreign('topic_id')->references('id')->on('topics');
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
        Schema::dropIfExists('action_plan_topic');
    }
}
