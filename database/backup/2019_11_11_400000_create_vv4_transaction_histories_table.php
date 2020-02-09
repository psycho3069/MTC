<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVV4TransactionHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('thead_id')->index()->unsigned();
            $table->integer('voucher_id')->index()->unsigned();
            $table->double('debit',12,2)->default(0);
            $table->double('credit',12,2)->default(0);
            $table->double('amount',12,2)->default(0);
            $table->integer('status')->default(0);
            $table->integer('day_end')->unsigned()->default(1);
            $table->date('date');
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
        Schema::dropIfExists('transaction_histories');
    }
}
