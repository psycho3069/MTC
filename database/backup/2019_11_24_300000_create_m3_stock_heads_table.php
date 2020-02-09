<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateM3StockHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_heads', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('category',['inventory', 'restaurant']);
            $table->integer('type_id')->unsigned()->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->double('amount',13,3)->default(0);
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
        Schema::dropIfExists('stock_heads');
    }
}
