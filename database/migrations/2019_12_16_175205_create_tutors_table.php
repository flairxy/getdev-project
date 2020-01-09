<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('user_id');
            $table->string('tutor_id');
            // $table->integer('rating')->default(0);
            $table->integer('courses')->default(0);
            $table->integer('students')->default(0);
            $table->decimal('balance')->default(0.00);
            $table->decimal('total_earned')->default(0.00);
            $table->string('identity')->nullable();
            $table->boolean('identity_status')->default(0);
            $table->string('image')->nullable();
            $table->string('phone')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tutors');
    }
}
