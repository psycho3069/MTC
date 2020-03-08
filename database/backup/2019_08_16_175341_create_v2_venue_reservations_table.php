<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateV2VenuereservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('v2_venue_reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60);
            $table->string('org_name')->nullable();
            $table->string('designation')->nullable();
            $table->string('contact_no', 30);
            $table->date('start_date');
            $table->date('end_date')->nullable($value = true);
            $table->unsignedInteger('venue_id');
            $table->foreign('venue_id')
                  ->references('id')->on('v1_venues')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
            $table->integer('no_of_attendee');
            $table->string('price', 20)->nullable($value = true);
            $table->smallInteger('status');
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
        Schema::dropIfExists('v2_venue_reservations');
    }
}
