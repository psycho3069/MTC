<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateM4MisCurrentStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mis_current_stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stock_id')->unsigned()->index();
            $table->integer('date_id')->unsigned()->index();
            $table->integer('quantity')->unsigned()->default(0);
            $table->enum('unit', ['kg', 'liter', 'number', ])->nullable();
            $table->double('amount',14,2)->default(0);
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
        Schema::dropIfExists('mis_current_stocks');
    }
}
