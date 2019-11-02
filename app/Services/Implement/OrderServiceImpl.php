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
    protected $imageRepository;

    public function __construct(Order $order, OrderGood $orderGood, Commodity $commodity, Image $image)
    {
        $this->orderRepository = $order->query();
        $this->orderGoodRepository = $orderGood->query();
        $this->commodityRepository = $commodity->query();
        $this->imageRepository = $image->query();
    }


    /**
     * 获取全部订单
     *
     * @param integer $page 页码
     *
     * @return mixed 全部订单
     */
    public function list($page)
    {
        return $this->getList($page);
    }

    /**
     * 获取未付款订单列表
     *
     * @param integer $page 页码
     *
     * @return mixed 未付款订单列表
     */
    public function pendingPayment($page)
    {
        return $this->getList($page, '0');
    }

    /**
     * 获取待发货订单
     *
     * @param integer $page 页码
     *
     * @return mixed 待发货订单
     */
    public function beingProcessed($page)
    {
        return $this->getList($page, '1');
    }

    /**
     * 获取待收货订单
     *
     * @param integer $page 页码
     *
     * @return mixed 待收货订单
     */
    public function shipped($page)
    {
        return $this->getList($page, '2');
    }

    /**
     * 获取待评价订单
     *
     * @param integer $page 页码
     *
     * @return mixed 待评价订单
     */
    public function evaluate($page)
    {
        return $this->getList($page, '3');
    }

    /**
     * 获取订单列表
     *
     * @param integer $page  页码
     * @param string  $state 状态
     *
     * @return mixed 订单列表
     */
    private function getList($page, $state = null)
    {
        $builder = $this->orderRepository
            ->with('orderGood.image');
        if ($state != null) {
            $builder->where('state', $state);
        }
        $builder->orderBy('id', 'desc');
        $orders = $builder
            ->offset((($page ?? 1) - 1) * 10)
            ->limit(10)
            ->get();
        return $orders;
    }

    /**
     * 立即购买创建订单
     *
     * @param mixed   $good    商品数组
     * @param integer $user_id 用户ID
     * @param Address $address 地址
     * @param string  $remarks 备注
     *
     * @return Order 创建后的订单
     * @throws Exception
     */
    public function createOne($good, $user_id, $address, $remarks): Order
    {
        \DB::beginTransaction();
        $order = $this->orderRepository->create([
            'number'      => Order::createOrderNo(),
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
        $commodity = $this->commodityRepository->sharedLock()->find($good['id']);
        if (!$commodity) {
            throw new Exception('商品不存在');
        }
        if ($commodity->count_stack < $good['count']) {
            throw new Exception('商品库存不足');
        }
        $orderGood = $this->createOrderGood($commodity, $order->id, $good['count']);
        $totalPrice += $orderGood->pay * $orderGood->count;
        $order->price = $totalPrice;
        $order->save();
        // TODO: 订单统计所有的优惠金额
        \DB::commit();
        return $order;
    }

    /**
     * 购物车创建多商品订单
     *
     * @param array   $commodities 商品数组
     * @param integer $user_id     用户ID
     * @param Address $address     地址
     * @param string  $remarks     备注
     *
     * @return Order 创建后的订单
     * @throws Exception
     */
    public function createByCart(array $commodities, $user_id, $address, $remarks): Order
    {
        \DB::beginTransaction();
        $order = $this->orderRepository->create([
            'number'      => Order::createOrderNo(),
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
            $orderGood = $this->createOrderGood($commodity, $order->id, $good['count']);
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

    /**
     * 创建订单商品
     *
     * @param Commodity $commodity 商品
     * @param integer   $order_id  订单ID
     * @param integer   $count     数量
     *
     * @return OrderGood 创建后的订单商品
     */
    private function createOrderGood($commodity, $order_id, $count)
    {
        $orderGood = $this->orderGoodRepository->create([
            'commodity_id' => $commodity->id,
            'pay'          => $commodity->price,
            'order_id'     => $order_id,
            'count'        => $count,
            'title'        => $commodity->title,
            'reward'       => 0,
        ]);
        $commodity->count_stack -= $orderGood->count;
        $commodity->save();
        $this->imageRepository->firstOrCreate([
            'image_type' => 'orderGood',
            'image_id'   => $orderGood->id,
            'url'        => $commodity->bannerImages[0]->url
        ]);
        return $orderGood;
    }

    /**
     * 获取订单
     *
     * @param integer $id 订单ID
     *
     * @return Order 订单
     */
    public function find($id): Order
    {
        $order = $this->orderRepository
            ->findOrFail($id);
        return $order;
    }

    /**
     * 取消订单
     *
     * @param integer $id 订单ID
     *
     * @return Order 取消后的订单 为已失效订单
     * @throws Exception
     */
    public function cancel($id): Order
    {
        $order = $this->orderRepository->with('orderGood.commodity')->findOrFail($id);
        if (!in_array($order->state, [Order::PENDING_PAYMENT, Order::BEING_PROCESSED])) {
            throw new Exception('订单无法取消');
        }
        \DB::beginTransaction();
        switch ($order->state) {
            case Order::PENDING_PAYMENT :
                $order->state = Order::INVALID;
                break;
            case Order::BEING_PROCESSED:
                // TODO 退款操作
                $order->state = Order::INVALID;
                break;
        }
        $order->save();

        // 商品库存回滚
        $orderGoods = $order->orderGood;
        foreach ($orderGoods as $good) {
            $commodity = $good->commodity;
            if ($commodity) {
                $commodity->count_stack += $good->count;
                if ($order->state == Order::BEING_PROCESSED) {
                    $commodity->count_sales -= $good->count;
                }
                $commodity->save();
            }
        }
        \DB::commit();
        return $order;
    }
}
