<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateH8RoomBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h8_room_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guest_name');
            $table->string('guest_contact');
            $table->double('amount')->unsigned()->default(0);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->unsignedInteger('room_id');
            $table->foreign('room_id')
                                ->references('id')
                                ->on('h6_rooms')
                                ->onUpdate('cascade')
                                ->onDelete('restrict');
            $table->smallInteger('status');
            $table->integer('mis_voucher_id')->unsigned()->index();
            $table->integer('venue_booking_id')->nullable();
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
        Schema::dropIfExists('h8_room_bookings');
    }
}
