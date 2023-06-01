<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVnpayPaymentModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vnpay_payment_models', function (Blueprint $table) {
            $table->id();  // cái này được xem như là id của đơn hàng 
            $table->string('thanh_vien');
            $table->bigInteger('money');//giá trị đơn hàng
            $table->string('note');//ghi chú thanh toán
            $table->integer('status_response_code');//mã thanh toán đơn hàng
            $table->string('code_bank');// hình thức thanh toán 
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
        Schema::dropIfExists('vnpay_payment_models');
    }
}
