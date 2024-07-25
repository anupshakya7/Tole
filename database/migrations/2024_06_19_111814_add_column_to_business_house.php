<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToBusinessHouse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_house', function (Blueprint $table) {
            $table->string('business_owner')->nullable()->after('contact');
            $table->string('business_certi_no')->nullable()->after('business_owner');
            $table->string('location_swap_ward')->nullable()->after('business_certi_no');
            $table->string('location_swap_date')->nullable()->after('location_swap_ward');
            $table->string('business_reg_date')->nullable()->after('location_swap_date');
            $table->string('business_certificate')->nullable()->after('business_reg_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_house', function (Blueprint $table) {
            //
        });
    }
}
