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

    /**
     * 获取商品和封面图
     *
     * @param integer $id 商品ID
     *
     * @return mixed
     */
    public function getWithImage($id);
}
