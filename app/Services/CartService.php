<?php


namespace App\Services;


use App\Commodity;

interface CartService
{
    /**
     * 创建购物车
     *
     * @param Commodity $commodity 商品
     * @param integer   $user_id   用户ID
     *
     * @return mixed
     */
    public function create(Commodity $commodity, $user_id);
}
