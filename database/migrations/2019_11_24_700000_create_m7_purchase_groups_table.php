<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateM7PurchaseGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mis_head_id')->unsigned()->index();
            $table->integer('date_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('purchase_groups');
    }
}
