<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateH9RoomBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h9_room_billings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id')->unsigned();
            $table->foreign('booking_id')
                                ->references('id')
                                ->on('h8_room_bookings')
                                ->onUpdate('cascade')
                                ->onDelete('restrict');
            $table->string('advance_pay')->nullable();
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
        Schema::dropIfExists('h9_room_billings');
    }
}
