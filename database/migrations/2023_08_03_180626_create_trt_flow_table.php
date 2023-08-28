<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrtFlowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trt_flow', function (Blueprint $table) {
            $table->bigIncrements('trt_flow_id')->index();
            $table->unsignedBigInteger('patients_id')->index();
            $table->string('unique_url',50)->nullable();
            $table->string('apt',150)->nullable();
            $table->string('current_health_goal',50)->nullable();
            $table->string('toward_health_goal',50)->nullable();
            $table->string('weight_goal',50)->nullable();
            $table->string('weight_lbs',50)->nullable();
            $table->string('energy',50)->nullable();
            $table->string('sleep',50)->nullable();
            $table->string('libido',50)->nullable();
            $table->string('memory',50)->nullable();
            $table->string('strength',50)->nullable();
            $table->tinyInteger('future_children')->nullable();
            $table->tinyInteger('living_children')->nullable();
            $table->tinyInteger('testosterone')->nullable();
            $table->tinyInteger('cream_and_gel')->nullable();
            $table->tinyInteger('allergies')->nullable();
            $table->tinyInteger('herbal_or_vitamin')->nullable();
            $table->tinyInteger('medications_prescribed')->nullable();
            $table->string('cold_chills',50)->nullable();
            $table->string('cold_hand_and_feet',50)->nullable();
            $table->string('decreased_sweating',50)->nullable();
            $table->string('thinning_skin',50)->nullable();
            $table->string('excessive_body_hair',50)->nullable();
            $table->string('nail_brittle',50)->nullable();
            $table->string('dry_brittle',50)->nullable();
            $table->string('hair_loss',50)->nullable();
            $table->string('dry_skin',50)->nullable();
            $table->string('thinning_public_hair',50)->nullable();
            $table->string('low_libido',50)->nullable();
            $table->string('memory_lapsed',50)->nullable();
            $table->string('difficulty_concentrating',50)->nullable();
            $table->string('deperssion',50)->nullable();
            $table->string('stress',50)->nullable();
            $table->string('anxiety',50)->nullable();
            $table->string('sleep_disturbances',50)->nullable();
            $table->string('aches_and_pains',50)->nullable();
            $table->string('headaches',50)->nullable();
            $table->string('tired',50)->nullable();
            $table->string('hoarseness',50)->nullable();
            $table->string('slowed_reflexes',50)->nullable();
            $table->string('constipation',50)->nullable();
            $table->string('hear_palpitation',50)->nullable();
            $table->string('fast_heart_rate',50)->nullable();
            $table->string('sugar_cravings',50)->nullable();
            $table->string('weight_gain',50)->nullable();
            $table->string('weight_loss_difficulty',50)->nullable();
            $table->string('decreased_muscle_mass',50)->nullable();
            $table->string('hot_flashes',50)->nullable();
            $table->string('excessive_sweating',50)->nullable();
            $table->string('excessive_facial_hair',50)->nullable();
            $table->string('increased_acne',50)->nullable();
            $table->string('oily_skin',50)->nullable();
            $table->string('irritability',50)->nullable();
            $table->string('mood_changes',50)->nullable();
            $table->string('incontinence',50)->nullable();
            $table->string('puffy_eyes',50)->nullable();
            $table->string('low_blood_pressure',50)->nullable();
            $table->string('slow_heart_rate',50)->nullable();
            $table->string('weight_loss',50)->nullable();
            $table->tinyInteger('same_shipping_as_billing')->nullable();
            $table->tinyInteger('same_as_credit_card')->nullable();
            $table->tinyInteger('acknowledge')->nullable();
            $table->string('additional_information',255)->nullable();
            $table->integer('experience')->nullable();
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
        Schema::dropIfExists('trt_flow');
    }
}
