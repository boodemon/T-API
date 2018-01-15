<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestourantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restourants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('restourant');
            $table->string('contact');
            $table->string('tel',64);
            $table->string('image');
            $table->enum('active',['N','Y']);
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
        Schema::drop('restourants');
    }
}
