<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableGroupsMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups_members', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->Integer('member_id')->unsigned()->index();            
            $table->Integer('member_groupid')->unsigned()->index();
			$table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('member_groupid')->references('id')->on('member_groups')->onDelete('cascade');
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
        Schema::dropIfExists('groups_members');
    }
}
