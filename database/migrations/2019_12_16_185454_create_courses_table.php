<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('title');
            $table->string('cover_image');
            $table->string('slug');
            $table->integer('rating')->default(0);
            $table->bigInteger('tutor_id')->unsigned();
            $table->bigInteger('total_student')->unsigned()->default(0);
            $table->bigInteger('total_outlines')->unsigned()->default(0);
            $table->bigInteger('total_earned')->unsigned()->default(0);
            $table->bigInteger('category_id')->unsigned();
            $table->integer('total_chapters');
            $table->integer('status')->default(0);
            $table->integer('type')->default(0);
            $table->unsignedDecimal('price')->default(0.00);
            $table->unsignedDecimal('promo_price')->default(0.00);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tutor_id')->references('id')->on('tutors')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
