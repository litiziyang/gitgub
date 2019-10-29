<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->comment('订单编号');
            $table->unsignedInteger('transaction_id')->nullable()->comment('交易编号');
            $table->unsignedInteger('user_id')->comment('用户ID');
            $table->enum('state', [0, 1, 2, 3, 4, 5])->default(0)->comment('订单状态 0 待付款 1 待发货 2 待收货 3 待评价 4 已失败 5 已完成');
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
        Schema::dropIfExists('orders');
    }
}
