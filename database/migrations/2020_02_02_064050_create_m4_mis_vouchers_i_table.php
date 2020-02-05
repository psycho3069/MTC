<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateM4MisVouchersITable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m4_mis_vouchers_i', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mis_head_id')->unsigned()->index();
            $table->integer('ledger_head_id')->unsigned()->index();
            $table->integer('date_id')->unsigned()->index();
            $table->integer('voucher_id')->unsigned()->index();
            $table->softDeletes();
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
        Schema::dropIfExists('m4_mis_vouchers_i');
    }
}
