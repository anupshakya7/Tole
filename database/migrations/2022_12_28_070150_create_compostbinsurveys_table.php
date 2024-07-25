<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompostbinsurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compostbinsurveys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->Integer('user_id')->unsigned()->index();
            $table->string('house_no')->nullable();
            $table->string('road')->nullable();
            $table->string('tol')->nullable();
            $table->string('owner')->nullable();
            $table->string('contact')->nullable();
            $table->bigInteger('compostbin_usage')->nullable();
            $table->string('compostbin_source')->nullable();
            $table->bigInteger('compostbin_seperated')->nullable();
            $table->text('remarks')->nullable();
            $table->string('house_storey')->nullable();
            $table->string('no_kitchen')->nullable();
            $table->string('total_people')->nullable();

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
        Schema::dropIfExists('compostbinsurveys');
    }
}
