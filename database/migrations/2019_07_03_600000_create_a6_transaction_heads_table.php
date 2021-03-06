<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateA6TransactionHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_heads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ac_head_id')->index()->unsigned();
            $table->string('name');
            $table->decimal('debit',14,2)->default(0);
            $table->decimal('credit',14,2)->default(0);
            $table->decimal('amount',14,2)->default(0);
            $table->string('code')->unique();
            $table->integer('transactionable_id');
            $table->string('transactionable_type');
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
        Schema::dropIfExists('transaction_heads');
    }
}
