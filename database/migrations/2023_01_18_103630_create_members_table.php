<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('full_name');
			$table->string('dob');
			$table->string('gender');
			$table->string('temporary_address')->nullable();
			$table->string('father_name')->nullable();
			$table->string('mother_name')->nullable();
			$table->string('image')->nullable();
			$table->Integer('occupation_id')->unsigned();
			$table->bigInteger('created_by');
			$table->bigInteger('updated_by');
			
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
        Schema::dropIfExists('members');
    }
}
