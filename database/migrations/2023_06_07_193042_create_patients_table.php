<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('patients_id')->index();
            $table->unsignedBigInteger('product_id')->index()->nullable();
            $table->string('survey_form_type',20)->nullable();
            $table->string('first_name',50)->nullable();
            $table->string('last_name',50)->nullable();
            $table->enum('gender',['M','F'])->nullable();
            $table->date('dob')->nullable();
            $table->date('profile_claimed')->nullable();
            $table->string('image',255)->nullable();
            $table->string('member_id',20)->nullable();
            $table->string('email',255)->nullable();
            $table->string('ssn',10)->nullable();
            $table->string('phone_no',15)->nullable();
            $table->string('country_code',5)->nullable();
            $table->string('city_name',50)->nullable();
            $table->string('zip',10)->nullable();
            $table->text('address')->nullable();
            $table->unsignedBigInteger('state_id')->index()->nullable();
            $table->text('billing_address_1')->nullable();
            $table->text('billing_address_2')->nullable();
            $table->text('billing_address_3')->nullable();
            $table->unsignedBigInteger('billing_state_id')->index()->nullable();
            $table->string('billing_city_name',50)->nullable();
            $table->string('billing_zip',10)->nullable();
            $table->text('shipping_address_1')->nullable();
            $table->text('shipping_address_2')->nullable();
            $table->text('shipping_address_3')->nullable();
            $table->unsignedBigInteger('shipping_state_id')->index()->nullable();
            $table->string('shipping_city_name',50)->nullable();
            $table->string('shipping_zip',10)->nullable();
            $table->double('height')->nullable();
            $table->double('weight')->nullable();
            $table->string('time_zone',20)->nullable();
            $table->integer('trt_refill')->nullable();
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('patients');
    }
}
