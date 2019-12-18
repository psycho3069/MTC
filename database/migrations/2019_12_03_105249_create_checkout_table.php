<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckoutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkout', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('h_start_date')->nullable();
            $table->date('h_end_date')->nullable();
            $table->string('name', 191)->nullable();
            $table->integer('contact')->nullable();
            $table->integer('room_no')->nullable();
            $table->integer('room_unit_price')->nullable();
            $table->integer('h_total_day')->nullable();
            $table->integer('h_total_bill')->nullable();
            $table->date('v_start_date')->nullable();
            $table->date('v_end_date')->nullable();
            $table->string('venue_no', 191)->nullable();
            $table->integer('v_unit_price')->nullable();
            $table->integer('v_total_day')->nullable();
            $table->integer('v_total_bill')->nullable();
            $table->integer('r_total_bill')->nullable();
            $table->integer('venue_booking_id')->nullable();
            $table->integer('room_booking_id')->nullable();
            $table->integer('all_total')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('grand_total')->nullable();
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
        Schema::dropIfExists('checkout');
    }
}
