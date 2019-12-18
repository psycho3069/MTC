<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateM5StocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stock_head_id')->unsigned()->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('quantity')->unsigned()->default(0);
            $table->enum('unit', ['kg', 'liter', 'number', ])->nullable();
            $table->double('amount',14,2)->unsigned()->default(0);
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
        Schema::dropIfExists('stocks');
    }
}
