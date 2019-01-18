<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_plans', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->integer('type')->default(0);
            $table->smallInteger('collaboration')->default(0);
            $table->string('objectives')->nullable();
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
        Schema::dropIfExists('action_plans');
    }
}
