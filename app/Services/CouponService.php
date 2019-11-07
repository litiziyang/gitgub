<?php


namespace App\Services;

use App\Coupon;
use App\User;

interface CouponService
{
    /**
     * @param int $user_id
     *
     * @return mixed 返回优惠券
     */
    public function getCoupon($user_id);
}
