<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignsKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('action_plan_configurations', function($table) {
            $table->foreign('user_id', 'apceei_fk')->references('id')->on('users');
            $table->foreign('action_plan_id', 'apcapapi_fk')->references('id')->on('action_plans')->onDelete('cascade');
            $table->foreign('coach_id', 'apceci_fk')->references('id')->on('users');
        });

        Schema::table('action_configurations', function($table) {
            $table->foreign('action_id', 'acaai_fk')->references('id')->on('actions')->onDelete('cascade');
            $table->foreign('action_plan_configuration_id', 'acacpapci_fk')->references('id')->on('action_plan_configurations')->onDelete('cascade');
        });

        Schema::table('evaluation_configurations', function($table) {
            $table->foreign('action_test_id', 'evatati_fk')->references('id')->on('action_tests');
            $table->foreign('action_configuration_id', 'ecacaci_fk')->references('id')->on('action_configurations');
        });

        Schema::table('plan_answers', function($table) {
            $table->foreign('plan_question_id', 'papqpqi_fk')->references('id')->on('plan_questions');
            $table->foreign('action_configuration_id', 'papqaci_fk')->references('id')->on('action_configurations');
            $table->foreign('user_id', 'paupaui_fk')->references('id')->on('users');

        });

        Schema::table('plan_questions', function($table) {
            //$table->foreign('action_id', 'pqaai_fk')->references('id')->on('actions')->onDelete('cascade');
            //$table->foreign('action_plan_id', 'pqapapi_fk')->references('id')->on('action_plans')->onDelete('cascade');
        });

        Schema::table('plan_question_options', function($table) {
            $table->foreign('plan_question_id', 'pqopqpqi_fk')->references('id')->on('plan_questions')->onDelete('cascade');
        });

        Schema::table('action_plan_configuration_user', function($table) {
            $table->foreign('action_plan_configuration_id', 'apceapcapci_fk')->references('id')->on('action_plan_configurations')->onDelete('cascade');
            $table->foreign('user_id', 'apceeei_fk')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('user_evaluation_configuration', function($table) {
            $table->foreign('user_id', 'eeceei_fk')->references('id')->on('users');
            $table->foreign('evaluation_configuration_id', 'eecececi_fk')->references('id')->on('evaluation_configurations');
        });

        Schema::table('interests', function($table) {
            $table->foreign('user_id', 'ieei_fk')->references('id')->on('users');
        });

        Schema::table('user_interest', function($table) {
            $table->foreign('user_id', 'eieei_fk')->references('id')->on('users');
            $table->foreign('interest_id', 'eiiii_fk')->references('id')->on('interests');
        });

        Schema::table('group_user', function($table) {
            $table->foreign('user_id', 'guuui_fk')->references('id')->on('users');
            $table->foreign('group_id', 'puggi_fk')->references('id')->on('groups');
        });

        Schema::table('department_user', function($table) {
            $table->foreign('user_id', 'duuui_fk')->references('id')->on('users');
            $table->foreign('department_id', 'duddi_fk')->references('id')->on('departments');
        });

        Schema::table('interest_topic', function($table) {
            $table->foreign('interest_id', 'itiii_fk')->references('id')->on('interests');
            $table->foreign('topic_id', 'ittti_fk')->references('id')->on('topics');
        });

        Schema::table('questions', function($table) {
            $table->foreign('micro_content_id', 'qmcmci_fk')->references('id')->on('micro_contents')->onDelete('cascade');
        });

        Schema::table('pages', function($table) {
            $table->foreign('micro_content_id', 'pmcmci_fk')->references('id')->on('micro_contents')->onDelete('cascade');
        });

        Schema::table('free_contents', function($table) {
            $table->foreign('action_plan_id', 'fcapapi_fk')->references('id')->on('action_plans')->onDelete('cascade');
        });

        Schema::table('micro_contents', function($table) {
            $table->foreign('user_id', 'mcuui_fk')->references('id')->on('users');
        });

        Schema::table('micro_content_topic', function($table) {
            $table->foreign('micro_content_id', 'mctmcmci_fk')->references('id')->on('micro_contents')->onDelete('cascade');
            $table->foreign('topic_id', 'mcttti_fk')->references('id')->on('topics')->onDelete('cascade');
        });

        Schema::table('answers', function($table) {
            $table->foreign('question_id', 'aqqi_fk')->references('id')->on('questions')->onDelete('cascade');
        });

        Schema::table('answer_user_question', function ($table) {
            $table->foreign('user_id', 'auquui_fk')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('question_id', 'auqqqi_fk')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('answer_id', 'auqaai_fk')->references('id')->on('answers')->onDelete('cascade');
        });

        Schema::table('action_plan_topic', function($table) {
            $table->foreign('action_plan_id', 'aptapapi_fk')->references('id')->on('action_plans')->onDelete('cascade');
            $table->foreign('topic_id', 'apttti_fk')->references('id')->on('topics')->onDelete('cascade');
        });

        Schema::table('actions', function($table) {
            $table->foreign('action_plan_id', 'aapapi_fk')->references('id')->on('action_plans')->onDelete('cascade');
        });

        Schema::table('action_micro_content', function($table) {
            $table->foreign('action_id', 'amcaai_fk')->references('id')->on('actions')->onDelete('cascade');
            $table->foreign('micro_content_id', 'amcmcmci_fk')->references('id')->on('micro_contents')->onDelete('cascade');
        });

        Schema::table('action_tests', function($table) {
            $table->foreign('action_id', 'ataai_fk')->references('id')->on('actions');
        });

        Schema::table('notifications', function($table) {
            $table->foreign('user_id', 'neei_fk')->references('id')->on('users');
        });

        Schema::table('entity_notifications', function($table) {
            $table->foreign('notification_id', 'ennni_fk')->references('id')->on('notifications');
        });

        Schema::table('user_visibilities', function($table) {
            $table->foreign('user_id', 'eveei_fk')->references('id')->on('users');
            $table->foreign('target_user_id', 'evetei_fk')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('free_contents', function($table) {
            $table->dropForeign('action_plan_id');
            $table->dropColumn('action_plan_id');
        });

        Schema::table('action_plan_configurations', function($table) {
            $table->dropForeign('user_id');
            $table->dropColumn('user_id');
            $table->dropForeign('action_plan_id');
            $table->dropColumn('action_plan_id');
            $table->dropForeign('coach_id');
            $table->dropColumn('coach_id');
        });

        Schema::table('action_configurations', function($table) {
            $table->dropForeign('action_id');
            $table->dropColumn('action_id');
            $table->dropForeign('action_plan_configuration_id');
            $table->dropColumn('action_plan_configuration_id');
        });

        Schema::table('evaluation_configurations', function($table) {
            $table->dropForeign('action_test_id');
            $table->dropColumn('action_test_id');
            $table->dropForeign('action_configuration_id');
            $table->dropColumn('action_configuration_id');
        });

        Schema::table('plan_answers', function($table) {
            $table->dropForeign('plan_question_id');
            $table->dropColumn('plan_question_id');
            $table->dropForeign('action_configuration_id');
            $table->dropColumn('action_configuration_id');
        });

        Schema::table('plan_questions', function($table) {
            //$table->dropForeign('action_id');
           // $table->dropColumn('action_id');
        });

        Schema::table('plan_question_options', function($table) {
            $table->dropForeign('plan_question_id');
            $table->dropColumn('plan_question_id');
        });

        Schema::table('action_plan_configuration_user', function($table) {
            $table->dropForeign('action_plan_configuration_id');
            $table->dropColumn('action_plan_configuration_id');
            $table->dropForeign('user_id');
            $table->dropColumn('user_id');
        });

        Schema::table('user_evaluation_configuration', function($table) {
            $table->dropForeign('user_id');
            $table->dropColumn('user_id');
            $table->dropForeign('evaluation_configuration_id');
            $table->dropColumn('evaluation_configuration_id');
        });

        Schema::table('interests', function($table) {
            $table->dropForeign('user_id');
            $table->dropColumn('user_id');
        });

        Schema::table('user_interest', function($table) {
            $table->dropForeign('user_id');
            $table->dropColumn('user_id');
            $table->dropForeign('interest_id');
            $table->dropColumn('interest_id');
        });

        Schema::table('interest_topic', function($table) {
            $table->dropForeign('interest_id');
            $table->dropColumn('interest_id');
            $table->dropForeign('topic_id');
            $table->dropColumn('topic_id');
        });

        Schema::table('questions', function($table) {
            $table->dropForeign('micro_content_id');
            $table->dropColumn('micro_content_id');
        });

        Schema::table('pages', function($table) {
            $table->dropForeign('micro_content_id');
            $table->dropColumn('micro_content_id');
        });

        Schema::table('micro_contents', function($table) {
            $table->dropForeign('user_id');
            $table->dropColumn('user_id');
        });

        Schema::table('answer_user_question', function ($table) {
            $table->dropForeign('user_id');
            $table->dropColumn('user_id');
            $table->dropForeign('question_id');
            $table->dropColumn('question_id');
            $table->dropForeign('answer_id');
            $table->dropColumn('answer_id');
        });

        Schema::table('micro_content_topic', function($table) {
            $table->dropForeign('micro_content_id');
            $table->dropColumn('micro_content_id');
            $table->dropForeign('topic_id');
            $table->dropColumn('topic_id');
        });

        Schema::table('answers', function($table) {
            $table->dropForeign('question_id');
            $table->dropColumn('question_id');
        });

        Schema::table('action_plan_topic', function($table) {
            $table->dropForeign('action_plan_id');
            $table->dropColumn('action_plan_id');
            $table->dropForeign('topic_id');
            $table->dropColumn('topic_id');
        });

        Schema::table('actions', function($table) {
            $table->dropForeign('action_plan_id');
            $table->dropColumn('action_plan_id');
        });

        Schema::table('action_micro_content', function($table) {
            $table->dropForeign('action_id');
            $table->dropColumn('action_id');
            $table->dropForeign('micro_content_id');
            $table->dropColumn('micro_content_id');
        });

        Schema::table('action_tests', function($table) {
            $table->dropForeign('action_id');
            $table->dropColumn('action_id');
        });

        Schema::table('notifications', function($table) {
            $table->dropForeign('user_id');
            $table->dropColumn('user_id');
        });

        Schema::table('entity_notifications', function($table) {
            $table->dropForeign('notification_id');
            $table->dropColumn('notification_id');
        });

        Schema::table('user_visibilities', function($table) {
            $table->dropForeign('user_id');
            $table->dropColumn('user_id');
            $table->dropForeign('target_user_id');
            $table->dropColumn('target_user_id');
        });
    }
}
