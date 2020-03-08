<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateH6RoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h6_rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->String('room_no',100);
            $table->integer('price');
            $table->integer('floor_id')->unsigned();
            $table->foreign('floor_id')
                                ->references('id')
                                ->on('h4_floors')
                                ->onUpdate('cascade')
                                ->onDelete('restrict');
            $table->integer('persons_capacity');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')
                                ->references('id')
                                ->on('h5_room_categories')
                                ->onUpdate('cascade')
                                ->onDelete('restrict');
            $table->String('description',255)->nullable();
            $table->String('image',60)->nullable();
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
        Schema::dropIfExists('h6_rooms');
    }
}
