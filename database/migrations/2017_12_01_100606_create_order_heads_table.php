<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_heads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id');
            $table->string('jobname',120);
            $table->string('address');
            $table->DateTime('jobdate');
            $table->double('price',15,2);
            $table->double('charge',15,2);
            $table->double('tax',15,2);
            $table->string('status',20);
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
        Schema::drop('order_heads');
    }
}
