<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddDeliveryNumberToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::table('orders', function (Blueprint $table) {
            if (\Schema::hasColumn('orders', 'delivery_number')) {
                $table->string('delivery_number')->nullable()->comment('快递单号');
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
        \Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
