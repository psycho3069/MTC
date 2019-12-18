<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateE4EmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e4_employees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('department_id')->unsigned()->index();
            $table->enum('type_id', [0,3,5])->default(0);
            $table->string('name');
            $table->date('date_of_birth')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->char('blood_group', 10)->nullable();
            $table->integer('designation_id')->unsigned()->index()->default(0);
            $table->integer('salary_grade_id')->unsigned()->index()->default(0);
            $table->char('emergency_contact', 30)->nullable();
            $table->text('other')->nullable();
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
        Schema::dropIfExists('e4_employees');
    }
}
