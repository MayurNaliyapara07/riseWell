<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->bigIncrements('product_id')->index();
            $table->unsignedBigInteger('category_id')->index()->nullable();
            $table->double('price')->default(0);
            $table->double('discount')->default(0);
            $table->double('shipping_cost')->default(0);
            $table->double('processing_fees')->default(0);
            $table->string('sku',150)->nullable();
            $table->enum('type',['OneTime','Subscription'])->nullable();
            $table->enum('product_type',['TRT','ED'])->nullable();
            $table->string('product_name',150)->nullable();
            $table->string('slug',150)->nullable();
            $table->text('benifit')->nullable();
            $table->string('membership_subscription',50)->nullable();
            $table->longText('long_description')->nullable();
            $table->text('sort_description')->nullable();
            $table->string('stripe_plan',255)->nullable();
            $table->string('image',255)->nullable();
            $table->enum('status',[0,1])->default(0);
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
        Schema::dropIfExists('product');
    }
}
