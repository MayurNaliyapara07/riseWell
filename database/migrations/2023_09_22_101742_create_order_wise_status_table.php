<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_wise_status', function (Blueprint $table) {
            $table->bigIncrements('order_wise_status_id')->index();
            $table->unsignedBigInteger('order_id')->index();
            $table->string('status')->index();
            $table->text('description')->nullable();
            $table->string('eventType')->nullable();
            $table->timestamp('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_wise_status');
    }
};
