<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateR8MenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r8_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->String('name',100);
            $table->integer('price');
            $table->integer('menu_type_id')
                                    ->unsigned();
            $table->foreign('menu_type_id')
                                    ->references('id')
                                    ->on('r7_menu_types')
                                    ->onUpdate('cascade')
                                    ->onDelete('restrict');
            $table->integer('item_1_id')->unsigned()->nullable();
            $table->foreign('item_1_id')->references('id')->on('r6_meal_items')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('item_1_quantity')->nullable();
            $table->integer('item_2_id')->unsigned()->nullable();
            $table->foreign('item_2_id')->references('id')->on('r6_meal_items')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('item_2_quantity')->nullable();
            $table->integer('item_3_id')->unsigned()->nullable();
            $table->foreign('item_3_id')->references('id')->on('r6_meal_items')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('item_3_quantity')->nullable();
            $table->integer('item_4_id')->unsigned()->nullable();
            $table->foreign('item_4_id')->references('id')->on('r6_meal_items')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('item_4_quantity')->nullable();
            $table->integer('item_5_id')->unsigned()->nullable();
            $table->foreign('item_5_id')->references('id')->on('r6_meal_items')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('item_5_quantity')->nullable();
            $table->integer('item_6_id')->unsigned()->nullable();
            $table->foreign('item_6_id')->references('id')->on('r6_meal_items')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('item_6_quantity')->nullable();
            $table->integer('item_7_id')->unsigned()->nullable();
            $table->foreign('item_7_id')->references('id')->on('r6_meal_items')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('item_7_quantity')->nullable();
            $table->integer('item_8_id')->unsigned()->nullable();
            $table->foreign('item_8_id')->references('id')->on('r6_meal_items')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('item_8_quantity')->nullable();
            $table->integer('item_9_id')->unsigned()->nullable();
            $table->foreign('item_9_id')->references('id')->on('r6_meal_items')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('item_9_quantity')->nullable();
            $table->integer('item_10_id')->unsigned()->nullable();
            $table->foreign('item_10_id')->references('id')->on('r6_meal_items')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('item_10_quantity')->nullable();
            $table->String('description',255)->nullable();
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
        Schema::dropIfExists('r8_menus');
    }
}
