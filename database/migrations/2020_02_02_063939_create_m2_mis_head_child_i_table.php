<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateM2MisHeadChildITable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m2_mis_head_child_i', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mis_head_id')->unsigned()->index();
            $table->integer('credit_head_id')->unsigned()->index();
            $table->integer('debit_head_id')->unsigned()->index();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('checked')->default(true);
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
        Schema::dropIfExists('m2_mis_head_child_i');
    }
}
