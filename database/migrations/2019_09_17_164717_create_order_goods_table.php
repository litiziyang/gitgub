<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_goods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('commodity_id')->comment('商品ID');
            $table->float('pay',8,2)->comment('当时价格');
            $table->unsignedInteger('order_id')->comment('订单ID');
            $table->unsignedInteger('count')->comment('数量');
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
        Schema::dropIfExists('order_goods');
    }
}
