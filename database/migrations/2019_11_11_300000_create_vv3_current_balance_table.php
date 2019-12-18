<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVV3CurrentBalanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_balance', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('thead_id')->unsigned()->index();
            $table->integer('date_id')->unsigned()->default(0);
            $table->double('debit',14,2)->default(0);
            $table->double('credit',14,2)->default(0);
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
        Schema::dropIfExists('current_balance');
    }
}
