<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->bigIncrements('notification_logs_id')->index();
            $table->bigInteger('user_id')->nullable();
            $table->string('sender')->nullable();
            $table->string('sent_from')->nullable();
            $table->string('sent_to')->nullable();
            $table->text('subject')->nullable();
            $table->text('message')->nullable();
            $table->string('notification_type')->nullable();
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
        Schema::dropIfExists('notification_logs');
    }
}
