<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_setting', function (Blueprint $table) {
            $table->bigIncrements('general_setting_id')->index();
            $table->string('email_from',255)->nullable();
            $table->string('site_title',50)->nullable();
            $table->string('site_logo',255)->nullable();
            $table->string('site_logo_dark',255)->nullable();
            $table->string('country_code',10)->nullable();
            $table->text('mail_config')->nullable();
            $table->text('sms_config')->nullable();
            $table->string('stripe_key',255)->nullable();
            $table->string('stripe_secret_key',255)->nullable();
            $table->string('stripe_webhook_key',150)->nullable();
            $table->string('zoom_client_url',255)->nullable();
            $table->string('zoom_client_secret_key',255)->nullable();
            $table->string('zoom_account_id',255)->nullable();
            $table->text('zoom_access_token')->nullable();
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
        Schema::dropIfExists('general_setting');
    }
}
