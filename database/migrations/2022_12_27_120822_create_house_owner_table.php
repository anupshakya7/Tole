<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouseOwnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('house_owner', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('gbin')->nullable();
            $table->string('house_no')->nullable();;
            $table->string('road')->nullable();;
            $table->string('tol')->nullable();;
            $table->string('owner')->nullable();
            $table->string('contact')->nullable();
            $table->string('mobile')->nullable();
            $table->string('respondent')->nullable();
            $table->string('occupation')->nullable();
            $table->string('gender')->nullable();
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
        Schema::dropIfExists('house_owner');
    }
}
