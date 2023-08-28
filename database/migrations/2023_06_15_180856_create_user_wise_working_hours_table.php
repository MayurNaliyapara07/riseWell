<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWiseWorkingHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_wise_working_hours', function (Blueprint $table) {
            $table->bigIncrements('user_wise_working_hours_id')->index();
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->string('day')->nullable();
            $table->string('start_time',10)->nullable();
            $table->string('end_time',10)->nullable();
            $table->tinyInteger('is_booked')->default(0);
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
        Schema::dropIfExists('user_wise_working_hours');
    }
}
