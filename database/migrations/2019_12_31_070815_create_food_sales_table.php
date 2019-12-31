<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('billing_id')->unsigned()->index();
//            $table->integer('booking_id')->unsigned()->index();
            $table->integer('menu_id')->unsigned()->index();
            $table->tinyInteger('quantity')->unsigned()->default(0);
            $table->double('bill',12,2)->unsigned()->default(0);
            $table->tinyInteger('vat')->unsigned()->default(15);

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
        Schema::dropIfExists('food_sales');
    }
}
