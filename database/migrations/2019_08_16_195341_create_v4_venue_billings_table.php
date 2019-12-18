<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateV4VenueBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('v4_venue_billings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('venue_booking_id')->unsigned();
            $table->string('advanced_pay')->nullable();
            $table->string('total_pay')->nullable();
            $table->integer('total_day')->nullable();
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
        Schema::dropIfExists('v4_venue_billings');
    }
}
