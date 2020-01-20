<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateR11FoodSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r11_food_sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('billing_id')->unsigned()->index();
            $table->integer('menu_id')->unsigned()->index();
            $table->tinyInteger('quantity')->unsigned()->default(0);
            $table->double('bill',12,2)->default(0);
            $table->double('discount',14,2)->default(0);
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
        Schema::dropIfExists('r11_food_sales');
    }
}
