<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use App\Http\Resources\OrderResource;
use App\Order;
use App\Services\AddressService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Validator;

class OrderController extends Controller
{
    protected $orderService;
    protected $addressService;

    public function __construct(OrderService $orderService, AddressService $addressService)
    {
        $this->middleware('jwt', ['except' => []]);
        $this->orderService = $orderService;
        $this->addressService = $addressService;
    }

    /**
     * 获取订单列表.
     *
     * @param Request $request
     *
     * @return BaseResource
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'page'  => 'sometimes|integer',
            'state' => 'sometimes|integer',
        ]);
        if ($validator->failed()) {
            return $this->validate();
        }
        $state = $data['state'] ?? 10;
        $page = $data['page'] ?? 1;
        switch ($state) {
            case 10 :
                $orders = $this->orderService->list($page, $request->user_id);
                break;
            case 0:
                $orders = $this->orderService->pendingPayment($page, $request->user_id);
                break;
            case 1:
                $orders = $this->orderService->beingProcessed($page, $request->user_id);
                break;
            case 2:
                $orders = $this->orderService->shipped($page, $request->user_id);
                break;
            case 3:
                $orders = $this->orderService->evaluate($page, $request->user_id);
                break;
            case 6:
                $orders = $this->orderService->afterSales($page, $request->user_id);
                break;
            default:
                return $this->validate();
                break;
        }
        return $this->success(OrderResource::collection($orders));
    }

    /**
     * 新增订单.
     *
     * @param Request $request
     *
     * @return BaseResource
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'commodities' => 'required|array',
            'address_id'  => 'required|integer',
            'remarks'     => 'required|string',
        ]);
        if ($validator->failed()) {
            return $this->validate();
        }
        $address = $this->addressService->find($data['address_id']);
        if (sizeof($data['commodities']) > 1) {
            $order = $this->orderService->createByCart($data['commodities'], $request->user_id, $address, $data['remarks']);
        } else {
            $order = $this->orderService->createOne($data['commodities'][0], $request->user_id, $address, $data['remarks']);
        }
        return $this->success([
            'price'  => $order->price,
            'number' => $order->number,
            'token'  => $order->getToken()
        ]);
    }

    /**
     * 返回单挑订单数据.
     *
     * @param int $id 订单ID
     *
     * @return Order
     */
    public function show($id)
    {
        return $this->orderService->find($id);
    }

    /**
     * 删除失效订单.
     *
     * @param integer $id 订单ID
     *
     * @return BaseResource
     */
    public function destroy($id)
    {
        if ($this->orderService->destroy($id)) {
            return $this->success();
        } else {
            return $this->failed('删除失败');
        }
    }

    /**
     * 返回订单数据
     *
     * @param Request $request
     *
     * @return BaseResource
     */
    public function pay(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'id' => 'required|integer',
        ]);
        if ($validator->failed()) {
            return $this->validate();
        }
        $order = $this->orderService->find($data['id']);
        return $this->success([
            'price'  => $order->price,
            'number' => $order->number,
            'token'  => $order->getToken()
        ]);
    }

    /**
     * 取消订单
     *
     * @param Request $request
     *
     * @return BaseResource
     */
    public function cancel(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'id' => 'required|integer'
        ]);
        if ($validator->failed()) {
            return $this->validate();
        }
        $order = $this->orderService->cancel($data['id']);
        return $this->success($order);
    }

    /**
     * 确认收货
     *
     * @param Request $request
     *
     * @return BaseResource
     */
    public function confirm(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'id' => 'required|integer'
        ]);
        if ($validator->failed()) {
            return $this->validate();
        }
        $this->orderService->confirm($data['id']);
        return $this->success();
    }

    /**
     * 获取各类订单的数量
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function count(Request $request)
    {
        return $this->success($this->orderService->count($request->user_id));
    }
}
