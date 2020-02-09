<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateR9SalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r9_sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('guest_id');
            $table->integer('menu_id');
            $table->string('menu_type');
            $table->integer('quantity');
            $table->integer('booking_status');
            $table->integer('mis_voucher_id')->unsigned()->index();
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
        Schema::dropIfExists('r9_sales');
    }
}
