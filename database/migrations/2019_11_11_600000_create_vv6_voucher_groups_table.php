<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVV6VoucherGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('date_id')->index()->unsigned();
            $table->integer('type_id')->index()->unsigned();
            $table->text('note');
            $table->text('code');
            $table->integer('user_id')->index()->unsigned();
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
        Schema::dropIfExists('voucher_groups');
    }
}
