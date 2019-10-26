<?php


namespace App\Services\Implement;


use App\Address;
use App\Cart;
use App\Commodity;
use App\Image;
use App\Order;
use App\OrderGood;
use App\Services\OrderService;
use Exception;

class OrderServiceImpl implements OrderService
{
    protected $orderRepository;
    protected $orderGoodRepository;
    protected $commodityRepository;

    public function __construct(Order $order, OrderGood $orderGood, Commodity $commodity)
    {
        $this->orderRepository = $order->query();
        $this->orderGoodRepository = $orderGood->query();
        $this->commodityRepository = $commodity->query();
    }

    /**
     * 创建订单
     *
     * @param array   $commodities 商品数组
     * @param integer $user_id     用户ID
     * @param Address $address     地址
     * @param string  $remarks     备注
     *
     * @return Order 创建后的订单
     * @throws Exception
     */
    public function create(array $commodities, $user_id, $address, $remarks): Order
    {
        \DB::beginTransaction();
        $order = $this->orderRepository->create([
            'number'      => count($commodities),
            'user_id'     => $user_id,
            'price'       => 0,
            'name'        => $address->name,
            'phone'       => $address->phone,
            'address'     => $address->address,
            'description' => $address->description,
            'remarks'     => $remarks,
            'longitude'   => $address->longitude,
            'latitude'    => $address->latitude,
        ]);
        $totalPrice = 0;
        foreach ($commodities as $good) {
            $cart = Cart::query()
                ->with('image')
                ->with('commodity')
                ->where('state', '!=', '0')
                ->findOrFail($good['id']);
            if (!$cart) {
                throw new Exception('商品不可用或购物车异常');
            }
            // 判断商品是否可以购买
            $commodity = Commodity::query()->sharedLock()->find($cart->commodity_id);
            if (!$commodity) {
                // 购物车转为不可用
                \DB::rollBack();
                $cart->state = '0';
                $cart->save();
                throw new Exception('商品 ' . $cart->title . ' 不存在');
            }
            if ($commodity->count_stack < $good['count']) {
                throw new Exception('商品 ' . $cart->title . ' 库存不足');
            }
            $orderGood = $this->orderGoodRepository->create([
                'commodity_id' => $commodity->id,
                'pay'          => $commodity->price,
                'order_id'     => $order->id,
                'count'        => $good['count'],
                'reward'       => 0,
            ]);
            $commodity->count_stack -= $orderGood->count;
            $commodity->save();
            Image::create([
                'image_type' => 'orderGood',
                'image_id'   => $orderGood->id,
                'url'        => $commodity->bannerImages[0]->url
            ]);
            $totalPrice += $orderGood->pay * $orderGood->count;
            // TODO: 订单商品奖励计算，每个商品的reward，根据用户评级能获得部分，满级用户能获得全部……

            if ($cart->image) {
                $cart->image->delete();
            }
            $cart->delete();
        }
        $order->price = $totalPrice;
        $order->save();
        // TODO: 订单统计所有的优惠金额
        \DB::commit();
        return $order;
    }
}
