<?php


namespace App\Services\Implement;


use App\Cart;
use App\Commodity;
use App\Services\CommodityService;
use Exception;

class CommodityServiceImpl implements CommodityService
{
    protected $commodityRepository;
    protected $cartRepository;

    public function __construct(Commodity $commodity, Cart $cart)
    {
        $this->commodityRepository = $commodity->query();
        $this->cartRepository = $cart->query();
    }


    /**
     * 获取商品列表
     *
     * @param array $carts 购物车列表
     *
     * @return array 商品列表
     * @throws Exception
     */
    public function list(array $carts)
    {
        $carts = $this->cartRepository
            ->with('commodity')
            ->where('state', '1')
            ->whereIn('id', $carts)
            ->get();
        $commodities = [];
        foreach ($carts as $cart) {
            $commodity = $cart->commodity;
            if (!$commodity) {
                $cart->state = '0';
                $cart->save();
            } else {
                array_push($commodities, $commodity->id);
            }
        }
        if (count($commodities) == 0) {
            throw new Exception('商品不可用或购物车异常');
        }
        $commodities = $this->commodityRepository
            ->whereIn('id', $commodities)
            ->get();
        return $commodities;
    }
}