<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatbotGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chatbot_group', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('chatbot_id')->unsigned();
            $table->foreign('chatbot_id')
                  ->references('id')
                  ->on('chatbots')
                  ->onDelete('cascade');
            $table->integer('group_id')->unsigned();
            $table->foreign('group_id')
                  ->references('id')
                  ->on('groups')
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
        Schema::dropIfExists('chatbot_group');
    }
}
