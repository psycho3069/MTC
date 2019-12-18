<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateH5RoomCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h5_room_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->String('name',100);
            $table->integer('price');
            $table->integer('vat');
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
        Schema::dropIfExists('h5_room_categories');
    }
}
