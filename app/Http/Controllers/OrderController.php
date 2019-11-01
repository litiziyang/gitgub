<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
use App\Http\Resources\OrderResource;
use App\Order;
use App\Services\AddressService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
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
        $orders = [];
        switch ($state) {
            case 10 :
                $orders = $this->orderService->list($page);
                break;
            case 0:
                $orders = $this->orderService->pendingPayment($page);
                break;
            case 1:
                $orders = $this->orderService->shipped($page);
                break;
            case 2:
                $orders = $this->orderService->evaluate($page);
                break;
            default:
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
     * @throws ValidationException
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
     * Display the specified resource.
     *
     * @param Order $order
     *
     * @return Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Order   $order
     *
     * @return Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     *
     * @return Response
     */
    public function destroy(Order $order)
    {
        //
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
}
