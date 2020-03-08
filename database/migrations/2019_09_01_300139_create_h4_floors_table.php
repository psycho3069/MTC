<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateH4FloorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h4_floors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('building_id')->unsigned();
            $table->foreign('building_id')
                                ->references('id')
                                ->on('h2_buildings')
                                ->onUpdate('cascade')
                                ->onDelete('restrict');
            $table->String('name',100);
            $table->integer('floor_type')->unsigned();
            $table->foreign('floor_type')
                                ->references('id')
                                ->on('h3_floor_types')
                                ->onUpdate('cascade')
                                ->onDelete('restrict');
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
        Schema::dropIfExists('h4_floors');
    }
}
