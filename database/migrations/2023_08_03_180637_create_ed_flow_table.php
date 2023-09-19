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
            $table->tinyInteger('consent_to_treat')->nullable();
            $table->tinyInteger('terms')->nullable();
            $table->tinyInteger('vitals')->nullable();
            $table->tinyInteger('medical_problems')->nullable();
            $table->tinyInteger('erectile_dysfunction')->nullable();
            $table->tinyInteger('same_as_billing_address')->nullable();
            $table->string('unique_url',150)->nullable();
            $table->string('weekday',150)->nullable();
            $table->string('weekend',150)->nullable();
            $table->string('medical_problem',150)->nullable();
            $table->string('blood_pressure',150)->nullable();
            $table->string('blood_pressure_medication',150)->nullable();
            $table->string('medications',150)->nullable();
            $table->string('medication_conjunction',150)->nullable();
            $table->text('recreational_drugs')->nullable();
            $table->string('medication_prescription',150)->nullable();
            $table->string('other_conditions',150)->nullable();
            $table->string('treat',150)->nullable();
            $table->string('cardiovascular',150)->nullable();
            $table->string('diabetes',150)->nullable();
            $table->string('diabetes_level',150)->nullable();
            $table->string('thyroid',150)->nullable();
            $table->string('cholesterol',150)->nullable();
            $table->string('breathing',150)->nullable();
            $table->string('gastroesophageal',150)->nullable();
            $table->string('hyperactivity',150)->nullable();
            $table->string('allergies',150)->nullable();
            $table->string('allergies_list',150)->nullable();
            $table->string('pi',50)->nullable();
            $table->string('confidence_rate',150)->nullable();
            $table->string('treated_with',150)->nullable();
            $table->string('sexual_stimulation',150)->nullable();
            $table->string('sexual_stimulation_1',150)->nullable();
            $table->string('sexual_stimulation_2',150)->nullable();
            $table->string('sexual_dificult',150)->nullable();
            $table->string('billing_first_name',150)->nullable();
            $table->string('billing_last_name',150)->nullable();
            $table->string('card_no','15')->nullable();
            $table->string('expire_date',10)->nullable();
            $table->string('card_cvv','5')->nullable();
            $table->tinyInteger('billing_same_as_shipping')->nullable();
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
