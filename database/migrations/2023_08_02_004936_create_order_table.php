<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->bigIncrements('order_id')->index();
            $table->unsignedBigInteger('patients_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('sending_order_tracking_no')->nullable();
            $table->string('sending_lab_tracking_no')->nullable();
            $table->string('receiving_order_tracking_no')->nullable();
            $table->string('receiving_lab_tracking_no')->nullable();
            $table->enum('sending_order_status', ['NewOrder', 'Approved', 'Placed', 'Shipped', 'Arrived', 'Fulfilled', 'Delivered'])->nullable();
            $table->string('sending_order_shipment_status')->nullable();
            $table->enum('sending_lab_status', ['NewOrder', 'Approved', 'Placed', 'Shipped', 'Arrived', 'Fulfilled', 'Delivered', 'LabsReady'])->nullable();
            $table->string('sending_lab_shipment_status')->nullable();
            $table->enum('receiving_order_status', ['NewOrder', 'Approved', 'Placed', 'Shipped', 'Arrived', 'Fulfilled', 'Delivered'])->nullable();
            $table->string('receiving_order_shipment_status')->nullable();
            $table->enum('receiving_lab_status', ['NewOrder', 'Approved', 'Placed', 'Shipped', 'Arrived', 'Fulfilled', 'Delivered', 'LabsReady'])->nullable();
            $table->string('receiving_lab_shipment_status')->nullable();
            $table->string('session_id')->nullable();
            $table->string('currency', 50)->nullable();
            $table->string('customer_id', 50)->nullable();
            $table->string('customer_email', 291)->nullable();
            $table->string('customer_name', 50)->nullable();
            $table->string('customer_phone_no', 50)->nullable();
            $table->string('customer_address', 291)->nullable();
            $table->longText('product_details')->nullable();
            $table->longText('discount_details')->nullable();
            $table->string('invoice_id', 50)->nullable();
            $table->string('invoice_pdf', 291)->nullable();
            $table->string('mode', 50)->nullable();
            $table->string('payment_status', 50)->nullable();
            $table->string('subscription_id', 50)->nullable();
            $table->string('payment_method_id', 50)->nullable();
            $table->string('card_brand', 50)->nullable();
            $table->string('exp_month', 50)->nullable();
            $table->string('exp_year', 50)->nullable();
            $table->string('last4', 50)->nullable();
            $table->string('status', 50)->nullable();
            $table->decimal('sub_total')->nullable();
            $table->decimal('total_amount')->nullable();
            $table->decimal('shipping_and_processing_amount')->nullable();
            $table->tinyInteger('is_product_requested')->default(0);
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
        Schema::dropIfExists('order');
    }
}
