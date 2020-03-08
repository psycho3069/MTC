<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateA2AccountHeadChildI extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_head_child_i', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ac_head_id')->index()->unsigned();
            $table->string('name');
            $table->string('code');
            $table->BigInteger('amount')->default(0);
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
        Schema::dropIfExists('account_head_child_id_i');
    }
}
