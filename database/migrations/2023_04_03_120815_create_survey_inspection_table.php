<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyInspectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_inspection', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('house_no')->nullable();
			 $table->string('road')->nullable();
            $table->string('tol')->nullable();
			$table->string('usage')->nullable();
			$table->string('production_status')->nullable();
			$table->string('fast_decaying_usage')->nullable();
			$table->string('compost_production_interval')->nullable();
			$table->string('compost_production')->nullable();
			$table->string('issues')->nullable();
			$table->string('remarks')->nullable();
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
        Schema::dropIfExists('survey_inspection');
    }
}
