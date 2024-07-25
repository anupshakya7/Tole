<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installation', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedInteger('user_id');
			$table->unsignedBigInteger('order_id');
			$table->timestamp('scheduled_at');
			$table->timestamp('installed_at')->nullable();
			$table->text('remarks')->nullable();
			$table->string('cost')->nullable();
			
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('order_id')->references('id')->on('customers');
			
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
        Schema::dropIfExists('installation');
    }
}
