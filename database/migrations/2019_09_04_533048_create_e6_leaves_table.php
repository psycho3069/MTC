<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateE6LeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e6_leaves', function (Blueprint $table) {
            $table->increments('id');
            $table->String('name',100);
            $table->String('duration');
            $table->integer('leave_category_id')->unsigned();
            $table->foreign('leave_category_id')
                                    ->references('id')
                                    ->on('e5_leave_categories')
                                    ->onUpdate('cascade')
                                    ->onDelete('restrict');
            $table->String('description',255)->nullable();
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
        Schema::dropIfExists('e6_leaves');
    }
}
