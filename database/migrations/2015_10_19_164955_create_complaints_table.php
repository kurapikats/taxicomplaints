<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxi_complaints', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('taxi_id');
            $table->date('incident_date');
            $table->time('incident_time')->nullable();
            $table->string('incident_location');
            $table->text('notes')->nullable();
            $table->string('drivers_name')->nullable();
            $table->boolean('valid')->default(false);
            $table->boolean('mail_sent')->default(false);
            $table->unsignedInteger('created_by');
            $table->timestamps();

            $table->foreign('created_by')->references('id')
                ->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('taxi_complaints');
    }
}
