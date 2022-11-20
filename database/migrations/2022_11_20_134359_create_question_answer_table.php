<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_students', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->unsignedSmallInteger('school_id');
            $table->unsignedSmallInteger('gender_id');
            $table->unsignedSmallInteger('age');
            $table->string('language');
            $table->timestamps();

            $table->foreign('school_id','fk_tbl_students_school_id')->references('id')->on('mst_schools');
            $table->foreign('gender_id','fk_tbl_students_gender_id')->references('id')->on('mst_gender');
        });

        Schema::create('tbl_student_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('student_id');
            $table->unsignedSmallInteger('question_id');
            $table->unsignedSmallInteger('sub_question_id');
            $table->unsignedSmallInteger('option_id');
            $table->timestamps();

            $table->foreign('student_id','fk_tbl_student_data_student_id')->references('id')->on('tbl_students');
            $table->foreign('question_id','fk_tbl_student_data_question_id')->references('id')->on('mst_questions');
            $table->foreign('sub_question_id','fk_tbl_student_data_sub_question_id')->references('id')->on('mst_sub_questions');
            $table->foreign('option_id','fk_tbl_student_data_option_id')->references('id')->on('mst_question_options');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_answers');
    }
}
