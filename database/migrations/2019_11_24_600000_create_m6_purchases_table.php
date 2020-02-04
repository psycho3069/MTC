<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateM6PurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_group_id')->unsigned()->index();
            $table->integer('stock_id')->unsigned()->index();
            $table->double('quantity_cr', 10,3)->default(0);
            $table->double('quantity_dr', 10,3)->default(0);
            $table->double('amount',14,2)->default(0);
            $table->integer('unit_id')->unsigned()->index();
            $table->integer('supplier_id')->unsigned()->index();
            $table->integer('receiver_id')->unsigned()->index();
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
        Schema::dropIfExists('purchases');
    }
}
