<?php


namespace App\Services;


use App\Address;
use App\Order;

interface OrderService
{
    /**
     * 创建订单
     *
     * @param array   $commodities 商品数组
     * @param integer $user_id     用户ID
     * @param Address $address     地址
     * @param string  $remarks     备注
     *
     * @return Order 创建后的订单
     * @todo 还未计算优惠返现这些
     */
    public function create(array $commodities, $user_id, $address, $remarks): Order;
}
