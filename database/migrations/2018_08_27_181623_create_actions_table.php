<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('action_plan_id')->unsigned();
//            $table->foreign('action_plan_id')->references('id')->on('action_plans');
            $table->string('title');
            $table->string('objectives')->nullable();
            $table->float('objectives_percent')->default(0);
            $table->integer('action_plan_order')->default(0);
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
        Schema::dropIfExists('actions');
    }
}
