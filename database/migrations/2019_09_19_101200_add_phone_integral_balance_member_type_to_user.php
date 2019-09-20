<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneIntegralBalanceMemberTypeToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumns('users', ['phone', 'integral', 'balance', 'member_type'])) {
                $table->string('phone')-> nullable()->comment('手机号');
                $table->unsignedInteger('integral')->default(0)->comment('积分');
                $table->float('balance', 8, 2)->default(0)->comment('余额');
                $table->enum('member_type', [0, 1])->default(0)->comment('会员类型 0非会员');
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
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
