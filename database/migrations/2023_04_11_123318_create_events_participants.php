<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsParticipants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events_participants', function (Blueprint $table) {
            $table->bigIncrements('id');
			 $table->bigInteger('event_id')->unsigned()->index();   
            $table->foreign('event_id')->references('id')->on('events');         
            $table->bigInteger('participant_id')->unsigned()->index();
            $table->foreign('participant_id')->references('id')->on('participants');  
			$table->string('registered_at')->nullable();
			$table->string('dontated_at')->nullable();
			$table->string('cert_received_at')->nullable();
			$table->string('blood_grp_card_received_at')->nullable();
			$table->string('previous_donatiion_at')->nullable();
			
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
        Schema::dropIfExists('events_participants');
    }
}
