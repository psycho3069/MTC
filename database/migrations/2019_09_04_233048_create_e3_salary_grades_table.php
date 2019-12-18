<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateE3SalaryGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e3_salary_grades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',30);
            $table->smallInteger('type');
            $table->string('provident_fund');
            $table->string('basic_salary');
            $table->string('transportation_allowance');
            $table->string('dinning_allowance');
            $table->string('other_allowance');
            $table->string('home_rent');
            $table->string('gross_salary');
            $table->string('note')->nullable();
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
        Schema::dropIfExists('e3_salary_grades');
    }
}
