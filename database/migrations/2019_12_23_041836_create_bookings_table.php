<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('guest_id')->unsigned()->index();
            $table->integer('billing_id')->unsigned()->index();
            $table->integer('room_id')->unsigned()->index();
            $table->boolean('booking_status')->default(1);
            $table->date('start_date');
            $table->date('end_date');
            $table->tinyInteger('visitors')->unsigned()->default(0);
            $table->double('discount',12,2)->unsigned()->default(0);
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
        Schema::dropIfExists('bookings');
    }
}
