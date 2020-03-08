<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateH2BuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h2_buildings', function (Blueprint $table) {
            $table->increments('id');
            $table->String('name',100);
            $table->integer('building_type')->unsigned();
            $table->foreign('building_type')
                                ->references('id')
                                ->on('h1_building_types')
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
        Schema::dropIfExists('h2_buildings');
    }
}
