<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bank_image',60);
            $table->string('bank_name',120);
            $table->string('bank_branch',120);
            $table->string('bank_type',60);
            $table->string('bank_id',20);
            $table->string('bank_account',120);
            $table->integer('bank_sort');
            $table->enum('active',['N','Y','D']);
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
        Schema::drop('banks');
    }
}
