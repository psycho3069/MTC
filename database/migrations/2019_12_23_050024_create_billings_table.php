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
            $table->boolean('checking_status')->default(0);
            $table->double('total_bill', 12,2)->unsigned()->default(0);
            $table->double('advance_paid', 12,2)->unsigned()->default(0);
            $table->double('total_paid', 12,2)->unsigned()->default(0);
            $table->double('vat', 12,2)->unsigned()->default(0);
            $table->double('discount',12,2)->unsigned()->default(0);
            $table->enum('dis_type',[1,2])->default(1); /*'percentage' = 1, 'cash' = 2*/
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
