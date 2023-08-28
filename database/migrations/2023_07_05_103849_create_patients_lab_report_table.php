<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsLabReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients_lab_report', function (Blueprint $table) {
            $table->bigIncrements('patients_lab_report_id')->index();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('patients_id')->index()->nullable();
            $table->unsignedBigInteger('category_id')->index()->nullable();
            $table->string('value',50)->nullable();
            $table->string('score',50)->nullable();
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
        Schema::dropIfExists('patients_lab_report');
    }
}
