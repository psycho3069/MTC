<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateI1InventorySuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('i1_inventory_suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->string('phone_no',15);
            $table->string('address',255);
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
        Schema::dropIfExists('i1_inventory_suppliers');
    }
}
