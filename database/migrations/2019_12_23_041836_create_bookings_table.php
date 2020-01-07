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
            $table->tinyInteger('booking_status')->unsigned()->default(2);
            $table->tinyInteger('no_of_visitors')->unsigned()->default(0);
            $table->double('bill',14,2)->default(0);
            $table->tinyInteger('vat')->unsigned()->default(5);
            $table->date('start_date');
            $table->date('end_date');
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
