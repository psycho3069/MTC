<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVV7VoucherUpdateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_update_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('voucher_id')->unsigned()->index();
            $table->integer('date_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->double('amount',14,2)->default(0);
            $table->text('note');
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
        Schema::dropIfExists('voucher_update_histories');
    }
}
