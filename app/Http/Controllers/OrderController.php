<?php

namespace App\Http\Controllers;

use App\Http\Resources\BaseResource;
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
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
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
            'remarks'     => 'required|string'
        ]);
        if ($validator->failed()) {
            return $this->validate();
        }
        $address = $this->addressService->find($data['address_id']);
        $order = $this->orderService->create($data['commodities'], $request->user_id, $address, $data['remarks']);
        return $this->success([
            'price' => $order->price,
            'id'    => $order->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Order $order
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
     * @param Request    $request
     * @param \App\Order $order
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
     * @param \App\Order $order
     *
     * @return Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
