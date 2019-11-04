<?php

namespace App\Services;

use App\Address;
use App\Order;

interface OrderService
{
    /**
     * 购物车创建多商品订单
     *
     * @param array   $commodities 商品数组
     * @param integer $user_id     用户ID
     * @param Address $address     地址
     * @param string  $remarks     备注
     *
     * @return Order 创建后的订单
     * @todo 还未计算优惠返现这些
     * @todo 不符合单一职责原则
     */
    public function createByCart(array $commodities, $user_id, $address, $remarks): Order;

    /**
     * 立即购买创建订单
     *
     * @param mixed   $good    商品数组
     * @param integer $user_id 用户ID
     * @param Address $address 地址
     * @param string  $remarks 备注
     *
     * @return Order 创建后的订单
     */
    public function createOne($good, $user_id, $address, $remarks): Order;

    /**
     * 获取全部订单
     *
     * @param integer $page 页码
     *
     * @return mixed 全部订单
     */
    public function list($page);

    /**
     * 获取未付款订单列表
     *
     * @param integer $page 页码
     *
     * @return mixed 未付款订单列表
     */
    public function pendingPayment($page);

    /**
     * 获取待发货订单
     *
     * @param integer $page 页码
     *
     * @return mixed 待发货订单
     */
    public function beingProcessed($page);

    /**
     * 获取待收货订单
     *
     * @param integer $page 页码
     *
     * @return mixed 待收货订单
     */
    public function shipped($page);

    /**
     * 获取待评价订单
     *
     * @param integer $page 页码
     *
     * @return mixed 待评价订单
     */
    public function evaluate($page);

    /**
     * 获取订单
     *
     * @param integer $id 订单ID
     *
     * @return Order 订单
     */
    public function find($id): Order;

    /**
     * 取消订单
     *
     * @param integer $id 订单ID
     *
     * @return Order 取消后的订单 为已失效订单
     */
    public function cancel($id): Order;
}
