<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestimonialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('title');
			$table->string('slug');
			$table->text('body');
			$table->string('featured_image')->nullable();;
			 $table->boolean('status')->default(1);
			$table->text('excerpt');
			$table->text('meta_keywords')->nullable();;
			$table->text('meta_descriptions')->nullable();;
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
        Schema::dropIfExists('testimonials');
    }
}
