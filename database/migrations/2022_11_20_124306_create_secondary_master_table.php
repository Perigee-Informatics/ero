<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecondaryMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_schools', function (Blueprint $table) {
            $table->id();
            $table->string('code',20);
            $table->unsignedSmallInteger('province_id');
            $table->unsignedSmallInteger('district_id');
            $table->unsignedSmallInteger('local_level_id');
            $table->string('name_lc',200);
            $table->string('name_en',200)->nullable();
            $table->string('gps_lat',20)->nullable();
            $table->string('gps_long',20)->nullable();
            $table->smallInteger('display_order')->default(0);
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

            $table->unique('code','uq_mst_schools_code');
            $table->unique('name_lc','uq_mst_schools_name_lc');
            $table->unique('name_en','uq_mst_schools_name_en');

            $table->foreign('province_id','fk_mst_schools_province_id')->references('id')->on('mst_fed_province');
            $table->foreign('district_id','fk_mst_schools_district_id')->references('id')->on('mst_fed_district');
            $table->foreign('local_level_id','fk_mst_schools_local_level_id')->references('id')->on('mst_fed_local_level');
        });

        Schema::create('review_profile_master',function(Blueprint $table){
            $table->id();
            $table->string('code',20);
            $table->string('program_name_lc',200);
            $table->string('program_name_en',200)->nullable();
            $table->unsignedSmallInteger('program_year');
            $table->unsignedSmallInteger('subject');
            $table->unsignedSmallInteger('exam_duration');
            $table->timestamps();

            $table->foreign('program_year','fk_review_profile_master_program_year')->references('id')->on('mst_years');
        });

        Schema::create('work_assignee_master',function(Blueprint $table){
            $table->id();
            $table->unsignedSmallInteger('school_id');
            $table->unsignedSmallInteger('class_id');
            $table->unsignedSmallInteger('subject');
            $table->unsignedSmallInteger('no_of_copies');
            $table->datetime('date_time');
            $table->unsignedSmallInteger('assigned_by');
            $table->timestamps();

            $table->foreign('school_id','fk_review_profile_master_school_id')->references('id')->on('mst_schools');
            $table->foreign('class_id','fk_review_profile_master_class_id')->references('id')->on('mst_class');
            $table->foreign('assigned_by','fk_review_profile_master_assigned_by')->references('id')->on('users');
        });


        Schema::create('question_groups',function(Blueprint $table){
            $table->id();
            $table->string('title_lc',200);
            $table->string('title_en',200)->nullable();
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
        Schema::dropIfExists('mst_schools');
        Schema::dropIfExists('review_profile_master');
        Schema::dropIfExists('work_assignee_master');
        Schema::dropIfExists('question_groups');
    }
}
