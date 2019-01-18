<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionMicroContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_micro_content', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('micro_content_id')->unsigned();
            $table->foreign('micro_content_id')
                  ->references('id')
                  ->on('micro_contents')
                  ->onDelete('cascade');
            $table->integer('action_id')->unsigned();
            $table->foreign('action_id')
                  ->references('id')
                  ->on('actions')
                  ->onDelete('cascade');
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
        Schema::dropIfExists('action_micro_content');
    }
}
