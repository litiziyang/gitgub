<?php


namespace App\Services;


use App\Commodity;

interface CommodityService
{
    /**
     * 获取购物车商品列表
     *
     * @param array $carts 购物车列表
     *
     * @return array 商品列表
     */
    public function listByCart(array $carts);


    /**
     * 获取商品列表
     *
     * @param mixed $commodity_id 商品ID
     *
     * @return array 商品列表
     */
    public function list($commodity_id);

    /**
     * 获取商品和封面图
     *
     * @param integer $id 商品ID
     *
     * @return mixed
     */
    public function getWithImage($id);

    /**
     * 增加浏览次数
     *
     * @param Commodity $commodity 商品
     *
     * @return mixed
     */
    public function addView($commodity);
}
