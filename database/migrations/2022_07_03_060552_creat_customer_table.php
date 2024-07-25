<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatCustomerTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create("customers", function (Blueprint $table) {
      $table->bigIncrements("id");
      //$table->unsignedInteger('brand_id')->index();
      $table->string("first_name");
      $table->string("last_name");
      $table->string("phone");
      $table->string("email");
      $table->text("location")->nullable();
	  $table->string("company_name")->nullable();
	  $table->string("company_address")->nullable();
	  $table->string("concerned_person")->nullable();
	  $table->string("company_contact")->nullable();
	  $table->string("company_pan")->nullable();

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
    Schema::dropIfExists("customers");
  }
}
