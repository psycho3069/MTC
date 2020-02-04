<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateM3MisLedgerHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m3_mis_ledger_heads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mis_head_id')->unsigned()->index();
            $table->string('name');
            $table->integer('credit_head_id')->unsigned()->nullable();
            $table->integer('debit_head_id')->unsigned()->nullable();
            $table->integer('code')->unsigned()->unique();
            $table->double('amount', 14, 2)->default(0);
            $table->text('description')->nullable();
            $table->integer('unit_type_id')->unsigned()->index();
            $table->integer('ledgerable_id');
            $table->string('ledgerable_type');
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
        Schema::dropIfExists('m3_mis_ledger_heads');
    }
}
