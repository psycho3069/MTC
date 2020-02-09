<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateI4InventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('i4_inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->String('name',100);
            $table->integer('inventory_category_id')
                                    ->unsigned();
            $table->foreign('inventory_category_id')
                                    ->references('id')
                                    ->on('i3_inventory_categories')
                                    ->onUpdate('cascade')
                                    ->onDelete('restrict');
            $table->String('description',255)->nullable();
            $table->String('amount',191)->nullable();
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
        Schema::dropIfExists('i4_inventories');
    }
}
