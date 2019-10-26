<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressPhoneRemarksDescriptionLongitudeLatitudeNameToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!\Schema::hasColumns('orders', ['address', 'phone', 'remarks', 'description', 'longitude', 'latitude', 'name'])) {
                $table->string('address')->comment('地址');
                $table->string('description')->nullable()->comment('详细地址');
                $table->string('phone')->comment('电话');
                $table->string('remarks')->nullable('备注');
                $table->string('longitude')->nullable()->comment('经度');
                $table->string('latitude')->nullable()->comment('纬度');
                $table->string('name')->comment('姓名');
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
