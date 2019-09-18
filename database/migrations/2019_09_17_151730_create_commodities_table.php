<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommoditiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commodities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->comment('标题');
            $table->unsignedInteger('category_id')->comment('分类ID');
            $table->float('price', 8, 2)->comment('价格');
            $table->float('reward', 8, 2)->comment('奖励金');
            $table->unsignedInteger('count_sales')->default(0)->comment('销量');
            $table->unsignedInteger('count_comment')->default(0)->comment('评论数量');
            $table->unsignedInteger('count_view')->default(0)->comment('浏览数量');
            $table->unsignedInteger('count_stack')->default(0)->comment('库存数量');

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
        Schema::dropIfExists('commodities');
    }
}
