<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event', function (Blueprint $table) {
            $table->bigIncrements('event_id')->index();
            $table->string('event_name',255)->nullable();
            $table->enum('location_type',['In-Metting','Call','Zoom'])->nullable();
            $table->text('location')->nullable();
            $table->string('phone_no',15)->nullable();
            $table->text('description')->nullable();
            $table->string('event_link',100)->nullable();
            $table->string('zoom_join_url',255)->nullable();
            $table->string('color',30)->nullable();
            $table->string('day_type',30)->nullable();
            $table->string('duration',50)->nullable();
            $table->string('days',50)->nullable();
            $table->double('custom_duration')->nullable();
            $table->string('custom_duration_type',30)->nullable();
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
        Schema::dropIfExists('event');
    }
}
