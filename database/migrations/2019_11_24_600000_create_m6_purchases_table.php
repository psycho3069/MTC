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
            $table->smallInteger('quantity_cr')->default(0);
            $table->smallInteger('quantity_dr')->default(0);
            $table->double('amount',14,2)->default(0);
            $table->integer('supplier_id')->unsigned()->index();
            $table->integer('receiver_id')->unsigned()->index();
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
