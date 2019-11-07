<?php


namespace App\Services\Implement;

use App\Coupon;
use App\Services\CouponService;
use App\User;
use mysql_xdevapi\Schema;


class CouponServiceImp implements CouponService
{
    protected $couponRepository;

    public function __construct(Coupon $coupon)
    {
        $this->couponRepository = $coupon->query();
    }

    /**
     *
     *
     * @param int $user_id 用户id
     *
     * @return mixed 返回优惠券
     */
    public function getCoupon($user_id)
    {
        return $this->couponRepository
            ->where('user_id', $user_id)
            ->get();
    }
}
