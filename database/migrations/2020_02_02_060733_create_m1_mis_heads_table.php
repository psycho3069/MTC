<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateM1MisHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m1_mis_heads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('voucher_type_id')->unsigned()->index();
            $table->integer('credit_head_id')->unsigned()->index()->nullable();
            $table->integer('debit_head_id')->unsigned()->index()->nullable();
            $table->string('name');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('m1_mis_heads');
    }
}
