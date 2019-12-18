<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateM2MisVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mis_vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mis_ac_head_id')->unsigned()->index();
            $table->integer('ais_vgroup_id')->unsigned()->index()->default(0);
            $table->integer('ais_voucher_id')->unsigned()->index()->default(0);
            $table->integer('date_id')->index()->unsigned();
            $table->integer('credit_head_id')->unsigned()->index();
            $table->integer('debit_head_id')->unsigned()->index();
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
        Schema::dropIfExists('mis_vouchers');
    }
}
