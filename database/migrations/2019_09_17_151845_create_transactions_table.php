<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->comment('交易号');
            $table->unsignedInteger('user_id')->comment('用户ID');
            $table->float('price', 8, 2)->default(0)->comment('订单金额');
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
        // Schema::dropIfExists('transactions');
    }
}
