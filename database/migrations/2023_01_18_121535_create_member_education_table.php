<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_education', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->Integer('member_id')->unsigned()->index();
			$table->string('last_qualification');
			$table->string('passed_year');
			$table->bigInteger('created_by')->nullable();
			$table->bigInteger('updated_by')->nullable();
			
			$table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
			
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
        Schema::dropIfExists('member_education');
    }
}
