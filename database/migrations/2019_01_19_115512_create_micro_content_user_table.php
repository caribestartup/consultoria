<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMicroContentUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('micro_content_user', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('micro_content_id')->unsigned();
            $table->foreign('micro_content_id')
                  ->references('id')
                  ->on('micro_contents')
                  ->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            $table->float('nota', 8, 2)->default(0);
            $table->boolean('approve')->default(false);
            $table->boolean('approve_coach')->default(false);
            $table->boolean('doit')->default(false);
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
        Schema::dropIfExists('micro_content_user');
    }
}
