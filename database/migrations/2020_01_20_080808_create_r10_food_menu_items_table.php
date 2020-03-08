<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateR10FoodMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r10_food_menu_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('food_menu_id')->unsigned()->index();
            $table->integer('meal_item_id')->unsigned()->index();
            $table->smallInteger('quantity')->default(0);
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
        Schema::dropIfExists('r10_food_menu_items');
    }
}
