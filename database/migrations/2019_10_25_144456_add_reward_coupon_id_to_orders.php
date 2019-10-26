<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddRewardCouponIdToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::table('orders', function (Blueprint $table) {
            if (!\Schema::hasColumns('orders', ['reward', 'coupon_id'])) {
                $table->float('reward')->default(0)->comment('奖励金额');
                $table->unsignedInteger('coupon_id')->nullable()->comment('优惠券ID');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
