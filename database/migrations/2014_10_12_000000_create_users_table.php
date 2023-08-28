<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('user_type', ['Super Admin', 'Admin', 'Organization', 'Employee', 'Provider', 'User'])->nullable();
            $table->string('avatar',255)->nullable();
            $table->string('suffix',20)->nullable();
            $table->string('first_name',50)->nullable();
            $table->string('middle_name',50)->nullable();
            $table->string('last_name',50)->nullable();
            $table->string('email',255)->unique()->nullable();
            $table->string('country_code',5)->nullable();
            $table->string('phone_no',15)->nullable();
            $table->string('designation',50)->nullable();
            $table->string('school_name',100)->nullable();
            $table->string('time_zone',10)->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender',['M','F'])->nullable();
            $table->unsignedBigInteger('state_id')->index()->nullable();
            $table->string('city_name',50)->nullable();
            $table->string('zip',30)->nullable();
            $table->text('address')->nullable();
            $table->integer('age')->nullable();
            $table->text('bio')->nullable();
            $table->double('ssn')->nullable();
            $table->string('insurance_proof',255)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('is_approve')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
