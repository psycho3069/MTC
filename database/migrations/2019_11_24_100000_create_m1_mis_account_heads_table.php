<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateM1MisAccountHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mis_account_heads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('credit_head_id')->unsigned()->index();
            $table->integer('debit_head_id')->unsigned()->index();
            $table->enum('type', ['hotel', 'restaurant', 'inventory', 'training_center']);
            $table->boolean('default')->default(0);
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
        Schema::dropIfExists('mis_account_heads');
    }
}
