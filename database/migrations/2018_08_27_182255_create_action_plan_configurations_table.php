<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionPlanConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_plan_configurations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
//            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('action_plan_id')->unsigned();
//            $table->foreign('action_plan_id')->references('id')->on('action_plans');
            $table->boolean('public')->nullable();
            $table->boolean('has_coach')->nullable();
            $table->integer('coach_id')->unsigned()->nullable();
//            $table->foreign('coach_id')->references('id')->on('users');
            $table->string('coach_functions')->nullable();
            $table->boolean('tracing')->nullable();
            $table->boolean('reminders')->nullable();
            $table->integer('reminders_period')->nullable();
            $table->bigInteger('reminders_value')->nullable();
            $table->date('start_date')->nullable();
            $table->date('ending_date')->nullable();
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
        Schema::dropIfExists('action_plan_configurations');
    }
}
