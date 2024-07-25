<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distributions', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->bigInteger('program_id')->unsigned()->index();
			$table->string('house_no');
			$table->string('receiver');
			$table->string('mobile');
			$table->string('received_at');
			$table->Integer('user_id')->unsigned()->index();
			
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			
			$table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
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
        Schema::dropIfExists('distributions');
    }
}
