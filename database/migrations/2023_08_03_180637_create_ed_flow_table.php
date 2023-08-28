<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEdFlowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ed_flow', function (Blueprint $table) {
            $table->bigIncrements('ed_flow_id')->index();
            $table->unsignedBigInteger('patients_id')->index();
            $table->tinyInteger('policy')->nullable();
            $table->tinyInteger('terms')->nullable();
            $table->tinyInteger('vitals')->nullable();
            $table->tinyInteger('medical_problems')->nullable();
            $table->tinyInteger('erectile_dysfunction')->nullable();
            $table->tinyInteger('same_as_billing_address')->nullable();
            $table->string('unique_url',50)->nullable();
            $table->string('weekday',20)->nullable();
            $table->string('weekend',20)->nullable();
            $table->string('medical_problem',191)->nullable();
            $table->string('blood_pressure')->nullable();
            $table->string('blood_pressure_medication',50)->nullable();
            $table->string('medications',50)->nullable();
            $table->string('medication_conjunction',50)->nullable();
            $table->string('recreational_drugs',50)->nullable();
            $table->string('medication_prescription',50)->nullable();
            $table->string('other_conditions',50)->nullable();
            $table->string('treat',50)->nullable();
            $table->string('cardiovascular',50)->nullable();
            $table->string('diabetes',50)->nullable();
            $table->string('diabetes_level',50)->nullable();
            $table->string('thyroid',50)->nullable();
            $table->string('cholesterol',50)->nullable();
            $table->string('breathing',50)->nullable();
            $table->string('gastroesophageal',50)->nullable();
            $table->string('hyperactivity',50)->nullable();
            $table->string('allergies',50)->nullable();
            $table->string('allergies_list',50)->nullable();
            $table->string('pi',50)->nullable();
            $table->string('confidence_rate',50)->nullable();
            $table->string('treated_with',50)->nullable();
            $table->string('sexual_stimulation',50)->nullable();
            $table->string('sexual_stimulation_1',50)->nullable();
            $table->string('sexual_stimulation_2',50)->nullable();
            $table->string('sexual_dificult',50)->nullable();
            $table->string('billing_first_name',50)->nullable();
            $table->string('billing_last_name',50)->nullable();
            $table->string('card_no','15')->nullable();
            $table->string('expire_date',10)->nullable();
            $table->string('card_cvv','5')->nullable();
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
        Schema::dropIfExists('ed_flow');
    }
}
