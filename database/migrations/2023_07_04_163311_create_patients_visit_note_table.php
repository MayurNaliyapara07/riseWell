<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsVisitNoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients_visit_note', function (Blueprint $table) {
            $table->bigIncrements('patients_visit_note_id')->index();
            $table->unsignedBigInteger('patients_id')->index()->nullable();
            $table->string('icd_code')->nullable();
            $table->text('visit_note')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
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
        Schema::dropIfExists('patients_visit_note');
    }
}
