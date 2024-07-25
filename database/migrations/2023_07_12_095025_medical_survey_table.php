<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MedicalSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_survey', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->string('house_no')->nullable();;
            $table->string('road')->nullable();;
            $table->string('tol')->nullable();;
            $table->Integer('ownership')->nullable();
            $table->string('year_rented')->nullable();
            $table->string('mtreatment_at')->nullable();
            $table->string('rnot_chosing_ward')->nullable();
            $table->Integer('smoker')->nullable();
            $table->string('smoking_duration')->nullable();
            $table->string('full_child_vaccinate')->nullable();
            $table->string('missing_vaccine')->nullable();
            $table->Integer('mum_breast_fed')->nullable();
			
			$table->string('breast_unfed')->nullable();
            $table->string('breast_fed_duration')->nullable();
            $table->Integer('pregnancy_test')->nullable();
			$table->Integer('pregnancy_test_times')->nullable();
            $table->Integer('family_planning_done')->nullable();
            $table->string('family_planning_device')->nullable();
			
			$table->string('rubbish_mgmt')->nullable();
            $table->string('plastic_rubbish_mgmt')->nullable();
            $table->string('drinking_water_src')->nullable();
			$table->Integer('drinking_water_purify')->nullable();
            $table->string('method_water_purify')->nullable();
            $table->Integer('medical_insured')->nullable();
			$table->Integer('pneumonia_vacciated')->nullable();
            $table->string('non_communicable_disease')->nullable();
			
			$table->Integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('medical_survey');
    }
}
