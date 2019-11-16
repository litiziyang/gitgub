<?php


namespace App\Services\Implement;

use App\Coupon;
use App\Services\CouponService;


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


    public function createCoupon($offer, $share_id, $condition, $new)
    {
        $coupon = $this->couponRepository
            ->create([
                'user_id'   => $share_id,
                'offer'     => $offer,
                'name'      => '分享的优惠券',
                'condition' => $condition,
                'new'       => $new,
            ]);
        return $coupon;
    }
}
