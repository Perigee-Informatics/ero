<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('review_profile_id'); 
            $table->unsignedSmallInteger('question_no');
            $table->text('title');
            $table->unsignedSmallInteger('group_id'); 
            $table->unsignedSmallInteger('class_id'); 
            $table->unsignedSmallInteger('subject'); 
            $table->boolean('has_sub_questions')->default(false); 
            $table->boolean('has_options')->default(false); 
            $table->boolean('allow_multiple_options')->default(false); 
            $table->boolean('is_evaluation_type')->default(false); 
            $table->timestamps();
            $table->unsignedSmallInteger('display_order')->default(0);

            $table->foreign('review_profile_id','fk_mst_questions_review_profile_id')->references('id')->on('review_profile_master');
            $table->foreign('group_id','fk_mst_questions_group_id')->references('id')->on('question_groups');
            $table->foreign('class_id','fk_mst_questions_class_id')->references('id')->on('mst_class');

        });

        Schema::create('mst_sub_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('question_id');
            $table->text('serial'); 
            $table->text('title'); 
            $table->unsignedSmallInteger('display_order')->default(0);
            $table->timestamps();
            $table->foreign('question_id','fk_mst_questions_question_id')->references('id')->on('mst_questions');

        });
        Schema::create('mst_question_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('question_id'); 
            $table->text('serial');
            $table->text('title');
            $table->string('correct_option',20)->nullable();
            $table->unsignedSmallInteger('display_order')->default(0);
            $table->timestamps();
            $table->foreign('question_id','fk_question_options_question_id')->references('id')->on('mst_questions');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_questions');
        Schema::dropIfExists('mst_sub_questions');
        Schema::dropIfExists('question_options');
    }
}
