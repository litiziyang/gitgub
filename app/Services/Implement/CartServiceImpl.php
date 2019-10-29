<?php


namespace App\Services\Implement;


use App\Cart;
use App\Commodity;
use App\Image;
use App\Services\CartService;

class CartServiceImpl implements CartService
{

    protected $cartRepository;
    protected $imageRepository;

    public function __construct(Cart $cart, Image $image)
    {
        $this->cartRepository = $cart->query();
        $this->imageRepository = $image->query();
    }


    /**
     * 创建购物车
     *
     * @param Commodity $commodity 商品
     * @param integer   $user_id   用户ID
     *
     * @return mixed
     */
    public function create(Commodity $commodity, $user_id)
    {
        $cart = $this->cartRepository->firstOrNew([
            'commodity_id' => $commodity->id,
            'user_id'      => $user_id,
        ]);
        // 冗余商品信息,用于商品数据不存在时显示
        $cart->title = $commodity->title;
        $cart->price = $commodity->price;
        $cart->count = $cart->count + 1;
        $cart->save();


        $this->imageRepository->firstOrCreate([
            'image_type' => 'cart',
            'image_id'   => $cart->id,
            'url'        => $commodity->bannerImages[0]->url,
        ]);
        return $cart;
    }
}
