<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatbotDesignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chatbot_design', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('chatbot_id')->unsigned();
            $table->foreign('chatbot_id')
                  ->references('id')
                  ->on('chatbots')
                  ->onDelete('cascade');
            $table->integer('question_id')->unsigned();
            $table->foreign('question_id')
                  ->references('id')
                  ->on('chatbot_questions')
                  ->onDelete('cascade'); 
            $table->integer('trigger_answer_id')->default(0);
            // $table->boolean('is_correct');
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
        Schema::dropIfExists('chatbot_design');
    }
}
