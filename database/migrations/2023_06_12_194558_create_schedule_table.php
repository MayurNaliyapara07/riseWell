<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule', function (Blueprint $table) {
            $table->bigIncrements('schedule_id')->index();
            $table->unsignedBigInteger('patients_id')->index();
            $table->unsignedBigInteger('assign_program_id')->index();
            $table->unsignedBigInteger('user_id')->index()->comment('providerId');
            $table->string('color',30)->nullable();
            $table->string('time_slot')->nullable();
            $table->date('date')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('schedule');
    }
}
