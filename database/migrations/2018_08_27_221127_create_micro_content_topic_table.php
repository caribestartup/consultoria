<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMicroContentTopicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('micro_content_topic', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('micro_content_id')->unsigned();
//            $table->foreign('micro_content_id')->references('id')->on('micro_contents');
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
        Schema::dropIfExists('micro_content_topic');
    }
}
