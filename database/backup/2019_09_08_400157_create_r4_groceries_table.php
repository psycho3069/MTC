<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateR4GroceriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r4_groceries', function (Blueprint $table) {
            $table->increments('id');
            $table->String('name',100);
            $table->integer('grocery_category_id')
                                    ->unsigned();
            $table->foreign('grocery_category_id')
                                    ->references('id')
                                    ->on('r3_grocery_categories')
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
        Schema::dropIfExists('r4_groceries');
    }
}
