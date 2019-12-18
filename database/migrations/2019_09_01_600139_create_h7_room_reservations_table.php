<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateH7RoomReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h7_room_reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('org_name');
            $table->string('guest_name');
            $table->string('guest_contact');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->unsignedInteger('room_id');
            $table->foreign('room_id')
                                ->references('id')
                                ->on('h6_rooms')
                                ->onUpdate('cascade')
                                ->onDelete('restrict');
            $table->smallInteger('status');
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
        Schema::dropIfExists('h7_room_reservations');
    }
}
