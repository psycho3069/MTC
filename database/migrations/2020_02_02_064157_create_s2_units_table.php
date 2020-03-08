<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateS2UnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s2_units', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unit_type_id')->unsigned()->index();
            $table->string('name');
            $table->string('short_name');
            $table->text('description')->nullable();
            $table->double('multiply_by', 14,6)->default(1);
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
        Schema::dropIfExists('s2_units');
    }
}
