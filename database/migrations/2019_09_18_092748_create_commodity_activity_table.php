<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommodityActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commodity_activity', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('commodity_id')->comment('商品ID');
            $table->unsignedInteger('activity_id')->comment('活动ID');
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
        Schema::dropIfExists('commodity_activity');
    }
}
