<?php


namespace App\Services;


interface CommodityService
{
    /**
     * 获取商品列表
     *
     * @param array $carts 购物车列表
     *
     * @return array 商品列表
     */
    public function list(array $carts);

}
