<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('guest_id')->unsigned()->index();
            $table->integer('mis_voucher_id')->unsigned()->index();
            $table->boolean('checkout_status')->default(0);
            $table->double('total_bill', 14,2)->default(0);
            $table->double('advance_paid', 14,2)->default(0);
            $table->double('total_paid', 14,2)->default(0);
            $table->double('discount',14,2)->unsigned()->default(0);
            $table->text('note')->nullable();
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
        Schema::dropIfExists('billings');
    }
}
